<?php
namespace app\controllers\admin;

use app\components\base\CActiveRecord;
use app\components\base\ModelUrl;
use app\controllers\base\AdminController;
use app\helpers\base\AdminHelper;
use app\models\SystemUser;
use app\models\SystemUserAdminRuntime;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotAcceptableHttpException;

class ModelController extends AdminController
{
    /** @var ModelUrl $url */
    public $url;

    public function actionIndex($handle = false)
    {
        $this->url = new ModelUrl($handle);

        $this->breadcrumbs = array_merge($this->breadcrumbs, $this->url->breadcrumbs);

        $action = $this->url->act;

        /** @var SystemUser $user */
        $user = Yii::$app->user->identity;
        if ($user->group) {
            $model = $user->group->getModels()->andWhere(['model' => $this->url->model])->one();
            if (!$model) throw new NotAcceptableHttpException();
        }

        return $this->{$action}();
    }

    public function index()
    {
        /** @var CActiveRecord $classname */
        $classname = $this->url->model;
        $options = $classname::getOptionsSorted();
        $title = $options['label'];
        $tabs = [];

        $runtime = SystemUserAdminRuntime::getUserRuntime($classname);
        if (Yii::$app->request->get('sort')) $runtime->sort = Yii::$app->request->get('sort');
        $runtime->save();

        $pageSize = 50;
        $params = [
            'pagination' => [
                'pageSize' => $pageSize,
            ],
        ];

        if (!empty($runtime->sort)) $params['sort']['defaultOrder'] = $runtime->sort;

        $formLinksAdditional = [];

        $searchModelClassName = $classname::$search_model_class;
        $searchModel = new $searchModelClassName();
        $searchModel->load(Yii::$app->request->get());
        $searchModel->validate();
        $columns = $classname::getColumns($searchModel);
        $criteria = $classname::find();
        if ($this->url->parent) {
            $parent = $this->url->parent_array;
            $criteria->andWhere([$parent[0] => $parent[1]]);

            ArrayHelper::removeValue($columns, ['attribute' => $parent[0]]);
            $back = $this->url->back;
            $classname_parent = $back->model;
            $id = $back->id;

            /** @var CActiveRecord $model */
            $model = $classname_parent::find()->where(['id' => $id])->oneOrNotFound();
            $tabs = $model->getAdminTabs($back, $this->url->tab);
            $title .= ', ' . $model->title;
            $formLinksAdditional = ['parent' => $parent];
        }
        if ($this->url->set) {
            $set = $this->url->set_array;
            $criteria->andWhere([$set[0] => $set[1]]);
            ArrayHelper::removeValue($columns, ['attribute' => $set[0]]);
            $formLinksAdditional = ['set' => $set];
        }
        //SystemUserGroup::criteria($criteria);

        if (Yii::$app->request->get('id2page')) {
            $pageCriteria = clone $criteria;
            $pageCriteria->orderBy($runtime->sort);
            $over = !empty($runtime->sort_val)?$runtime->sort_val:'id';
            $pageCriteria->select('row_number() OVER(ORDER BY '.$over.') as number, id');
            $numberTableQuery = $pageCriteria->createCommand()->rawSql;

            $ids = false;
            if ($ids) {
                $defaultPage = ceil($ids['number'] / $pageSize);
                $params['pagination']['page'] = $defaultPage - 1;
            }
            unset($_GET['id2page']);
        }

        $dataProvider = $searchModel->search($criteria, $params, Yii::$app->request->get());

        $formLinks = [];
        if ($options['tree']) {
            $formLinks['tree'] = [
                'label' => 'Дерево',
                'url' => Yii::$app->controller->url->createUrl(['act' => 'tree']),
                'type' => 'info',
            ];
        }
        $formLinks['create'] = [
            'label' => 'Создать',
            'url' => Yii::$app->controller->url->createUrl(array_merge(['act' => 'form'], $formLinksAdditional)),
            'type' => 'success',
        ];
        if ($options['sti'] == 2) {
            foreach ($options['stiModels'] as $stiClassName) {
                $stiOptions = $stiClassName::getOptions();

                $formLinks['create']['children'][] = [
                    'label' => $stiOptions['label'],
                    'url' => Yii::$app->controller->url->createUrl(array_merge(['mod' => substr(strrchr($stiClassName, "\\"), 1), 'act' => 'form'], $formLinksAdditional)),
                ];
            }
        }

        return $this->render('@app/views/admin/base/index', [
            'title' => $title,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'columns' => $columns,
            'tabs' => $tabs,
            'formLinks' => $formLinks,
        ]);
    }

    public function form() {
        $id = $this->url->id; $id = $id?((int)$id):false;

        /**
         * @var CActiveRecord $classname
         * @var CActiveRecord $model
         */
        $classname = $this->url->model;
        if ($id === false) {
            $model = new $classname;
            $model->setDefaults();
        } else {
            $model = $classname::find()->where(['id' => $id])->oneOrNotFound();
        }

        $model->setScenario('admin');
        if ($this->url->parent) {
            $parent = $this->url->parent_array;
            $model->{$parent[0]} = $parent[1];
        }
        $options = $classname::getOptionsSorted($model);

        if ($this->url->set) {
            $set = $this->url->set_array;
            $model->{$set[0]} = $set[1];
            $options['fields'][$set[0]]['edited'] = 0;
            $options['fields'][$set[0]]['inserted'] = 0;
        }
        if (Yii::$app->request->isPost) {
            $command = Yii::$app->request->post('submit');
            if (in_array($command, ['save', 'apply'])) {
                if ($model->loadAndSave()) {
                    if ($command == 'save') {
                        return $this->redirect($this->url->back->getUrl(false, ['id2page' => $model->id]));
                    } else {
                        return $this->redirect($this->url->back->createUrl(['mod' => $model->className, 'act' => 'form', 'id' => $model->id]));
                    }
                }
            }
            if (in_array($command, ['cancel'])) {
                return $this->redirect($this->url->back->getUrl(false, ['id2page' => $model->id]));
            }
        }

        $tabs = $model->getAdminTabs();

        $back = $this->url->back;
        if ($back) {
            $classname_back = $back->model;
            $backUrl = $back->url;
            $backLabel = $classname_back::getLabelTemplate('Назад к списку [content]', 'Р', true);
        } else {
            $backUrl = false;
            $backLabel = false;
        }

        return $this->render('@app/views/admin/base/form', [
            'title' => $options['label'],
            'model' => $model,
            'classname' => $classname,
            'options' => $options,
            'tabs' => $tabs,
            'backUrl' => $backUrl,
            'backLabel' => $backLabel,
        ]);
    }

    public function tree($type = false, $pid = false, $id = false) {
        $classname = $this->url->model;
        $type = Yii::$app->request->get('type', false);
        $pid = Yii::$app->request->get('pid', false);
        $id = Yii::$app->request->get('id', false);

        if ($type === false) {
            $models = $classname::find()->orderby('lft')->all();

            $formLinks = [];
            $formLinks['create'] = [
                'label' => 'Таблица',
                'type' => 'info',
                'url' => $this->url->back->url,
                'children' => [],
            ];

            return $this->render('@app/views/admin/base/tree', ['items' => $models, 'formLinks' => $formLinks]);
        } else {
            $parent = $classname::findOne($pid);
            $model = $classname::findOne($id);

            if ($parent && $model) {
                if ($type == 'inside') {
                    $model->prependTo($parent);
                } else {
                    $model->insertAfter($parent);
                }

                return 'true';
            }

            return 'false';
        }
    }

    public function delete() {
        /** @var CActiveRecord $classname */
        $classname = $this->url->model;
        $id = $this->url->id;

        $model = $classname::findOne(['id' => $id]);
        $model->controllerDelete();

        return $this->redirect($this->url->back->url);
    }
}
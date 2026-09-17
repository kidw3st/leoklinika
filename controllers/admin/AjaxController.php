<?php
namespace app\controllers\admin;

use app\components\base\CActiveRecord;
use app\controllers\base\AdminController;
use app\helpers\base\SystemHelper;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Response;

class AjaxController extends AdminController
{
    public function actionIndex($className, $target_field, $search = '')
    {
        $options = $className::getOptions();
        $field = $options['fields'][$target_field];

        if ($field['criteria']) {
            $criteria = $field['criteria'];
        } else {
            $cn = $field['linkiiParent'];
            $criteria = $cn::find();
        }

        $list = [
            'results' => [],
        ];
        if (strlen($search) > 2) {
            if (!empty($cn)) {
                $cn::ajaxSearch($criteria, $field['list_template'], $search);
            } else {
                $criteria->andWhere(['LIKE', $field['list_template'], $search]);
            }

            $res = ArrayHelper::map($criteria->all(), 'id', $field['list_template']);
            foreach ($res as $k => $val) {
                $list['results'][] = [
                    'id' => $k,
                    'text' => $val,
                ];
            }
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $list;
    }

    public function actionPublic($id, $model, $value, $force = false) {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $classname = 'app\\models\\' . $model;

        $result = [
            'type' => 'error',
            'message' => 'Неизвестная ошибка',
        ];

        /** @var CActiveRecord $item */
        $item = $classname::find()->where(['id' => $id])->one();
        if ($item) {
            $can_change = true;
            if ($value == 1 && $classname::$_is_locale && !$force && count($item->locales) != count(SystemHelper::AllLanguages())) {
                $can_change = false;
            }

            if ($can_change) {
                $item->public = $value;
                if ($item->save()) {
                    $item->refresh();
                    $result = [
                        'type' => 'success',
                        'view' => $item->getViewColumn('public'),
                    ];
                } else {
                    $result = [
                        'type' => 'error',
                        'message' => implode("\r\n", $item->firstErrors),
                    ];
                }
            } else {
                $result = [
                    'type' => 'danger',
                    'message' => 'Запись не переведена на все языки. Все равно публиковать?',
                ];
            }
        }
        return $result;
    }
}
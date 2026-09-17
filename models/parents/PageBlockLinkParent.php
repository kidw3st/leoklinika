<?php 
namespace app\models\parents;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\PageBlock;
use app\components\base\CActiveRecord;
/**
 * This is the model class for table "page_block_link".
 *
 * @property integer $id
 * @property array $options
 * @property string $title
 * @property string $link
 * @property integer $page_block_id
 * @property PageBlock $page_block
 * @property bool $public
 * @property integer $weight
 */
class PageBlockLinkParent extends CActiveRecord {
    public static function tableName()
    {
        return 'page_block_link';
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['title'], 'required', 'on' => ['default', 'admin']],
            [['title', 'link'], 'string', 'max' => 255, 'on' => ['default', 'admin']],
            [['page_block_id', 'weight'], 'integer', 'on' => ['default', 'admin']],
            [['public'], 'boolean', 'on' => ['admin']],

            [['title', 'link', 'page_block_id'], 'string', 'on' => 'search'],
            [['public'], 'boolean', 'on' => 'search'],
            [['weight'], 'integer', 'on' => 'search'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => 'ID',
            'title' => 'Наименование',
            'title_val' => 'Наименование',
            'link' => 'Ссылка',
            'link_val' => 'Ссылка',
            'page_block_id' => 'Блок',
            'page_block' => 'Блок',
            'public' => 'Публикация',
            'weight' => 'Порядок',
        ]);
    }


    public function getPage_block() {
        return $this->hasOne(PageBlock::class, ['id' => 'page_block_id']);
    }


    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
    }

    public function afterDelete()
    {
        parent::afterDelete();
    }

    public static function find()
    {
        $criteria = parent::find();
        return $criteria;
    }



    public function variables_refresh()
    {
    }

    public function behaviors() {
        return array_merge(parent::behaviors(), [
        ]);
    }

    public static $search_model_class = '\app\models\search\PageBlockLinkSearch';
    public static $model_title = 'Ссылка';
    public static function getOptions($model = false) {
        $options = array (
  'fields' => 
  array (
    'title' => 
    array (
      'sort' => 10,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'link' => 
    array (
      'sort' => 20,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'string',
      'editor' => 'input',
    ),
    'page_block_id' => 
    array (
      'sort' => 100,
      'locale' => 0,
      'type' => 'link_ITo1',
      'class' => 'app\\models\\PageBlock',
      'list_template' => 'title',
      'linki1Variable' => 'page_block',
      'link_ajax' => false,
    ),
    'public' => 
    array (
      'sort' => 100030,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'checkbox',
    ),
    'weight' => 
    array (
      'sort' => 100020,
      'locale' => 0,
      'viewed' => true,
      'edited' => true,
      'inserted' => true,
      'type' => 'number',
    ),
  ),
  'label' => static::$model_title,
  'children' => 
  array (
  ),
  'sti' => '1',
  'tree' => '0',
);

        if (!empty($options['children'])) {
            foreach ($options['children'] as $chKey => $chVal) {
                $options['children'][$chKey]['model'] = $chVal['model'];
            }
        }

        return ArrayHelper::merge(parent::getOptions($model), $options);
    }
}
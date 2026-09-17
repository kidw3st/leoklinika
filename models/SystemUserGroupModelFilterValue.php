<?php
namespace app\models;

use Yii;
use app\models\parents\SystemUserGroupModelFilterValueParent;

class SystemUserGroupModelFilterValue extends SystemUserGroupModelFilterValueParent
{
    public $set_update_time = false;

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
        
        ]);
    }
    
    public function rules()
    {
        return array_merge(parent::rules(), [
        
        ]);
    }

    /**
     * @param SystemUserGroupModelFilterValue $model
     * @return array
     */
    public static function getOptions($model = false)
    {
        $res = parent::getOptions($model);

        $res['fields']['value_str'] = [
            'sort' => 20,
            'type' => 'string',
            'viewed' => true,
        ];
        if ($model) {
            $column = $model->user_group_model_filter->column;
            $filterModel = $model->user_group_model_filter->user_group_model->model;

            $columns = explode('.', $column);
            $lastColumn = array_pop($columns);
            foreach ($columns as $columnItem) {
                if ($filterModel === false) break;
                $options = $filterModel::getOptions();

                $filterModel = false;
                foreach($options['fields'] as $attribute => $field) {
                    if (!empty($field['linki1Variable']) && $field['linki1Variable'] == $columnItem) {
                        $filterModel = $field['class'];
                        break;
                    }
                    if($attribute == $columnItem && $field['type'] == 'link_IToI') {
                        $filterModel = $field['linkiiParent'];
                        break;
                    }
                }
            }

            if ($filterModel && $lastColumn == 'id') {
                $res['fields']['value_id']['class'] = $filterModel;
            } else {
                $res['fields']['value_id']['type'] = 'string';
                $res['fields']['value_id']['editor'] = 'input';
            }
        }

        return $res;
    }

    public function getValue_str() {
        $options = static::getOptions($this);

        switch ($options['fields']['value_id']['type']) {
            case 'link_ITo1':
                $className = $options['fields']['value_id']['class'];
                $attribute = $options['fields']['value_id']['list_template'];

                $item = $className::find()->where(['id' => $this->value_id])->one();
                if ($item) {
                    return $className::find()->where(['id' => $this->value_id])->one()->{$attribute};
                } else {
                    return 'Значение отсутствует';
                }
            default:
                return $this->value_id;
        }
    }
}
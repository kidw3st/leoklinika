<?php
namespace app\models;

use app\components\base\CActiveQuery;
use app\helpers\base\AdminHelper;
use Yii;
use app\models\parents\SystemSettingsParent;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

class SystemSettings extends SystemSettingsParent
{
    protected static $module = false;
    public static $title = 'Настройки';
    public $insert_all_locale = true;

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'value_output' => 'Значение',
        ]);
    }

    public function rules()
    {
        return array_merge(parent::rules(), [

        ]);
    }

    public static function find()
    {
        if (static::$module) {
            $where = ['module' => static::$module];
            if (!is_array(static::$module)) static::$module = [static::$module];

            $where = ['OR'];
            $parts = [];
            foreach (static::$module as $mod) {
                if (strpos($mod, '%') === false) {
                    $parts[] = ['module' => $mod];
                } else {
                    $parts[] = new Expression('module LIKE "' . $mod . '"');
                }
            }
            $where = array_merge($where, $parts);

            return new CActiveQuerySystemSettings(get_called_class(), ['where' => $where]);
        }

        return parent::find();
    }

    public function init()
    {
        parent::init();
    }

    private static $_values = [];
    public static function getParam($module, $code, $default = false, $request = false, $type = 1) {
        if (!isset(static::$_values[$module][$code]) || $request) {
            $criteria = static::find()->where(['module' => $module, 'code' => $code]);
            $setting = $criteria->one();
            if (!$setting) {
                $setting = new static();
                $setting->title = $module . '_' . $code;
                $setting->module = $module;
                $setting->code = $code;
                $setting->type = $type;
                if ($type == 4) {
                    $setting->value_file = strval($default?:'');
                } else {
                    $setting->value = strval($default ?: '');
                }
                $setting->save();
            }

            if (in_array($setting->type, [4])) {
                static::$_values[$module][$code] = $setting->value_file;
            } elseif (in_array($setting->type, [5])) {
                static::$_values[$module][$code] = $setting->value_model;
            } else {
                static::$_values[$module][$code] = $setting->value;
            }
        }

        return static::$_values[$module][$code];
    }

    public static function getParamArray($module, $code, $default = [], $separator = "\r\n", $fill_key_with_value = false) {
        $param = trim(static::getParam($module, $code, implode($separator, $default), false, 2));

        if (!empty($param)) {
            $arr = explode($separator, $param);
            $res_arr = [];
            foreach ($arr as $k => $v) {
                if ($fill_key_with_value) {
                    $res_arr[trim($v)] = trim($v);
                } else {
                    $res_arr[$k] = trim($v);
                }
            }
            return $res_arr;
        }
        return [];
    }

    public static function setParam($module, $code, $value = false, $type = 1) {
        $criteria = static::find()->where(['module' => $module, 'code' => $code]);
        /** @var static $setting */
        $setting = $criteria->one();
        if (!$setting) {
            $setting = new static();
            $setting->title = $module . '_' . $code;
            $setting->module = $module;
            $setting->code = $code;
            $setting->type = $type;
        }

        if ($type == 4) {
            $setting->value_file = strval($value?:'');
        } else {
            $setting->value = strval($value ?: '');
        }
        $setting->set_update_time = false;
        $setting->save();

        if (in_array($setting->type, [4])) {
            static::$_values[$module][$code] = $setting->value_file;
        } elseif (in_array($setting->type, [5])) {
            static::$_values[$module][$code] = $setting->value_model;
        } else {
            static::$_values[$module][$code] = $setting->value;
        }
    }

    public static function getOptions($model = false)
    {
        $res = parent::getOptions($model);

        if ($model) {
            if ($model->type == 1) {
                $res['fields']['value']['edited'] = true;
                $res['fields']['value']['editor'] = 'input';
            } elseif ($model->type == 2) {
                $res['fields']['value']['edited'] = true;
                $res['fields']['value']['editor'] = 'textarea';
            } elseif ($model->type == 3) {
                $res['fields']['value']['edited'] = true;
                $res['fields']['value']['editor'] = 'redactor';
            } elseif ($model->type == 4) {
                $res['fields']['value_file']['edited'] = true;
            } elseif ($model->type == 5) {
                $res['fields']['model_class']['edited'] = true;
                $res['fields']['model_class']['items'] = ArrayHelper::map(AdminHelper::getModels(), 'classChild', 'label');

                if (!empty($model->model_class) && class_exists($model->model_class)) {
                    $res['fields']['value_model']['edited'] = true;
                    $cn = $model->model_class;
                    $res['fields']['value_model']['items'] = ArrayHelper::map($cn::find()->all(), 'id', 'admin_label');
                }
            } elseif ($model->type == 6) {
                $res['fields']['options']['edited'] = true;
            } elseif ($model->type == 7) {
                $res['fields']['value']['type'] = 'checkbox';
                $res['fields']['value']['edited'] = true;
            }
        }

        $res['fields']['value_output'] = [
            'viewed' => true,
            'type' => 'virtual',
            'sort' => 42,
        ];

        if (Yii::$app->params['admin']['debug'] == false) {
            $res['fields']['module']['inserted'] = false;
            $res['fields']['module']['edited'] = false;
            //$res['fields']['module']['viewed'] = false;

            $res['fields']['code']['inserted'] = false;
            $res['fields']['code']['edited'] = false;
            //$res['fields']['code']['viewed'] = false;

            $res['fields']['type']['inserted'] = false;
            $res['fields']['type']['edited'] = false;
            $res['fields']['type']['viewed'] = false;
        }

        return $res;
    }

    public function getValue_output() {
        switch ($this->type) {
            case 3:
                return '(Текст)';
            case 4:
                return $this->value_file;
            default:
                return $this->value;
        }
    }
}

class CActiveQuerySystemSettings extends CActiveQuery {
    public $where = false;

    public function prepare($builder)
    {
        if ($this->where) {
            $this->andWhere($this->where);
        }
        return parent::prepare($builder);
    }
}
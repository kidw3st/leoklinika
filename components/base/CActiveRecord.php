<?php

namespace app\components\base;

use app\helpers\base\SystemHelper;
use app\helpers\base\TextHelper;
use app\models\Language;
use app\models\SystemSettings;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class CActiveRecord extends ActiveRecord {
    public $success = false;
    private $_formNameSuffix = '';
    public $multiple_idx = false;
    public static $search_model_class = '';
    public static $_is_locale = false;
    public static $_locale_class = false;
    public $insert_all_locale = false;
    public $set_update_time = true;

    public function formNameWithVar($variable)
    {
        $vars = explode('[', $variable);
        $vars[0] = '[' . $vars[0] . ']';
        $vars = implode('[', $vars);

        return $this->formName() . (($this->multiple_idx!==false)?('['.$this->multiple_idx.']'):'') . $vars;
    }

    public static function find() {
        $f = new CActiveQuery(get_called_class());
        $f->alias(static::tableName());

        return $f;
    }

    public static function tableNameLocale() {
        return static::tableName().'_locale';
    }

    public function getFormNameSuffix() {
        return $this->_formNameSuffix;
    }

    public function setFormNameSuffix($value) {
        $this->_formNameSuffix = $value;
    }

    public function getClassName() {
        $cn = get_class($this);
        $cn = end(explode('\\', $cn));
        return $cn;
    }

    // Выводим массив столбцов для вывода в админке
    public static function getColumns($searchModel) {
        $options = static::getOptionsSorted();

        $res = ['id'];
        foreach($options['fields'] as $attribute => $field) {
            if (!empty($field['viewed'])) {
                $column = [
                    'attribute' => $attribute,
                ];

                $column['filter'] = $searchModel->field_filter_input($attribute);

                switch($field['type']) {
                    case 'file':
                        if (!empty($field['isImage'])) {
                            //$column['format'] = 'raw';
                            $column['content'] = function($data, $key, $index, $column) { return '<image src="'.$data->{$column->attribute.'_obj'}->doProp(100, 100).'" style="max-width: 100px; max-height: 100px; background: #ccc" />'; };
                        } else {
                            $column['content'] = function($data, $key, $index, $column) { return empty($data->{$column->attribute})?'Пусто':'<a target="_blank" href="'.$data->{$column->attribute}.'">Открыть</a>'; };
                        }
                        break;
                    case 'link_ITo1':
                        $column['content'] = function($model, $key, $index, $column) {
                            $options = $model->classOptions['fields'][$column->attribute];

                            $attribute = $options['linki1Variable'];
                            $variable = $options['list_template'];

                            return $model->{$attribute}->$variable;
                        };
                        break;
                    case 'link_IToI':
                        $column['content'] = function($model, $key, $index, $column) {
                            $options = $model->classOptions['fields'][$column->attribute];

                            $attribute = $options['linki1Variable'];
                            $variable = $options['list_template'];

                            return implode('<br/>', ArrayHelper::getColumn($model->{$column->attribute}, $variable));
                        };
                        break;
                    case 'checkbox':
                        $locale = $field['locale'];
                        $column['content'] = function($model, $key, $index, $column) use ($locale, $attribute) {
                            if ($model->{$column->attribute} == 1) {
                                $res = '<i style="color:#008000;" class="fa fa-check"></i>';
                            } else {
                                $res = '<i style="color:#FF0000;" class="fa fa-close"></i>';
                            }

                            if ($locale && $attribute == 'public') {
                                $exist_langs = ArrayHelper::map($model->locales, 'language_id', 'public');

                                $langs = SystemHelper::AllLanguages();
                                $res .= ' ';
                                foreach ($langs as $lang) {
                                    $res .= '<div class="label '.(!empty($exist_langs[$lang->id])?'bg-green':'bg-red').'">'.$lang->handle.'</div>';
                                }
                            }

                            return $res;
                        };
                        break;
                    case 'phone':
                        $column['content'] = function($model, $key, $index, $column) {
                            return $model->{$column->attribute.'_input'};
                        };
                        break;
                    case 'date':
                        $column['content'] = function($model, $key, $index, $column) {
                            return $model->{$column->attribute.'_input'};
                        };
                        break;
                    case 'datetime':
                        $column['content'] = function($model, $key, $index, $column) {
                            return $model->{$column->attribute.'_input'};
                        };
                        break;
                    case 'select':
                        $column['content'] = function($model, $key, $index, $column) {
                            return $model->{$column->attribute.'_val'};
                        };
                        break;
                    case 'virtual':
                        $column['format'] = 'html';
                        break;
                    case 'language':
                        $column['format'] = 'html';
                        $column['content'] = function($model, $key, $index, $column) {
                            $exist_langs = ArrayHelper::getColumn($model->locales, 'language_id');

                            $langs = SystemHelper::AllLanguages();
                            $res = '';
                            foreach ($langs as $lang) {
                                $res .= '<div class="label '.(in_array($lang->id, $exist_langs)?'bg-green':'bg-red').'">'.$lang->handle.'</div>';
                            }

                            return $res;
                        };
                        break;
                }

                $res[] = $column;
            }
        }

        $res[] = [
            'format' => 'raw',
            'content' => function($data, $key, $index, $column) {
                return implode('&nbsp;', $data->getActionButtons());
            },
        ];

        return $res;
    }

    public function getActionButtons() {
        $res = [];
        $res[] = '<a href="'.Yii::$app->controller->url->createUrl(['act' => 'form', 'id' => $this->id]).'"><span class="glyphicon glyphicon-pencil"></span></a>';
        $res[] = '<a href="'.Yii::$app->controller->url->createUrl(['act' => 'delete', 'id' => $this->id]).'" data-confirm="Вы точно хотите удалить запись?"><span class="glyphicon glyphicon-trash"></span></a>';

        return $res;
    }

    public function getLocales() {
        if (static::$_locale_class) {
            return $this->hasMany(static::$_locale_class, ['locale_parent_id' => 'id']);
        }

        return [];
    }

    public function formName()
    {
        return parent::formName() . $this->formNameSuffix;
    }

    public static function getOptions($model = false) {
        if (static::$_is_locale) {
            return [
                'fields' => [
                    'language_filled' => [
                        'type' => 'language',
                        'viewed' => true,
                    ]
                ],
            ];
        }

        return [];
    }

    public static function getOptionsSorted($model = false) {
        $res = static::getOptions($model);

        if (!empty($res['fields'])) {
            uasort($res['fields'], function($a, $b) {
                if ($a['sort'] > $b['sort']) {
                    return 1;
                } elseif($a['sort'] < $b['sort']) {
                    return -1;
                }
                return 0;
            });
        }

        return $res;
    }

    public function setDefaults() {

    }

    // Для быстрох пост запросов
    public function loadAndSave() {
        if (Yii::$app->request->isPost && $this->load(Yii::$app->request->post()) && $this->controllerSave()) {
            $this->success = true;
            return true;
        }

        return false;
    }

    // Вкладки для админки
    public function getAdminTabs($url = false, $activeMenu = false) {
        $options = static::getOptions();
        if ($url === false) $url = Yii::$app->controller->url;

        $tabs = [];
        if (!empty($options['children']) && !$this->isNewRecord) {
            $tabs['self'] = [
                'url' => $url->getUrl(),
                'label' => static::getLabelTemplate('[Content]'),
                'active' => ($activeMenu===false||$activeMenu=='self')?true:false,
            ];

            foreach($options['children'] as $variable => $child) {
                $childClassName = $child['model'];
                $childOption = $childClassName::getOptions();

                $tabs[$child['variable']] = [
                    'url' => $url->createUrl(['mod' => ModelUrl::getHandleByClass($childClassName), 'act' => 'index', 'parent' => [$child['model_id'], $this->id], 'tab' => $child['variable']]),
                    'label' => $childClassName::getLabelTemplate('[Content]', 'И', true),
                    'active' => ($activeMenu == $child['variable']) ? true : false,
                ];
            }
        }
        return $tabs;
    }

    public function beforeDelete()
    {
        $options = static::getOptions();
        if (!empty($options['children'])) {
            foreach ($options['children'] as $child) {
                if (!empty($child['link_delete']) && $this->{$child['variable']}) {
                    foreach ($this->{$child['variable']} as $childModel) {
                        $childModel->delete();
                    }
                }
            }
        }

        return parent::beforeDelete();
    }

    public static function phone2db($phone) {
        $phone = preg_replace("/[^0-9]/", "", $phone);

        return intval($phone);
    }

    public static function phoneFormat($phone, $convert = false, $trim = true) {
        // If we have not entered a phone number just return empty
        if (empty($phone)) {
            return '';
        }

        // Strip out any extra characters that we do not need only keep letters and numbers
        $phone = preg_replace("/[^0-9A-Za-z]/", "", $phone);

        // Do we want to convert phone numbers with letters to their number equivalent?
        // Samples are: 1-800-TERMINIX, 1-800-FLOWERS, 1-800-Petmeds
        if ($convert == true) {
            $replace = array('2'=>array('a','b','c'),
                '3'=>array('d','e','f'),
                '4'=>array('g','h','i'),
                '5'=>array('j','k','l'),
                '6'=>array('m','n','o'),
                '7'=>array('p','q','r','s'),
                '8'=>array('t','u','v'), '9'=>array('w','x','y','z'));

            // Replace each letter with a number
            // Notice this is case insensitive with the str_ireplace instead of str_replace
            foreach($replace as $digit=>$letters) {
                $phone = str_ireplace($letters, $digit, $phone);
            }
        }

        // If we have a number longer than 11 digits cut the string down to only 11
        // This is also only ran if we want to limit only to 11 characters
        if ($trim == true && strlen($phone)>11) {
            $phone = substr($phone,  0, 11);
        }

        // Perform phone number formatting here
        if (strlen($phone) == 7) {
            return preg_replace("/([0-9a-zA-Z]{3})([0-9a-zA-Z]{4})/", "$1-$2", $phone);
        } elseif (strlen($phone) == 10) {
            return preg_replace("/([0-9a-zA-Z]{3})([0-9a-zA-Z]{3})([0-9a-zA-Z]{4})/", "($1) $2-$3", $phone);
        } elseif (strlen($phone) == 11) {
            return preg_replace("/([0-9a-zA-Z]{1})([0-9a-zA-Z]{3})([0-9a-zA-Z]{3})([0-9a-zA-Z]{4})/", "$1($2) $3-$4", $phone);
        }

        // Return original phone if not 7, 10 or 11 digits long
        return $phone;
    }

    public static function generatePassword($password) {
        return md5($password);
    }

    public function getClassOptions() {
        $options = static::getOptions();

        return $options;
    }

    public static $eventCustomVariables = [];
    public static function getEventVariables($basicVar = '', $withII = false, $lvl = 1) {
        /** @var CActiveRecord $item */
        $item = new static();

        $options = static::getOptions();

        $vars = [];
        if ($lvl <= 4) {
            foreach ($item->attributes() as $attribute) {
                if (!empty($options['fields'][$attribute]) && $options['fields'][$attribute]['type'] == 'link_ITo1') {
                    $cn = $options['fields'][$attribute]['class'];
                    $vars[$item->getAttributeLabel($attribute)] = $cn::getEventVariables($basicVar . '.' . $options['fields'][$attribute]['linki1Variable'], $withII, $lvl + 1);
                } else {
                    $vars['[[' . $basicVar . '.' . $attribute . ']]'] = $item->getAttributeLabel($attribute);
                }
            }
            if ($withII) {
                foreach ($options['fields'] as $attribute => $field) {
                    if ($options['fields'][$attribute]['type'] == 'link_IToI') {
                        $cn = $options['fields'][$attribute]['linkiiParent'];
                        $vars[$item->getAttributeLabel($attribute)] = $cn::getEventVariables($basicVar . '.' . $attribute, $withII, $lvl + 1);
                    }
                }
            }
            foreach (static::$eventCustomVariables as $k => $val) {
                $vars['[[' . $basicVar . '.' . $k . ']]'] = $val;
            }
        }
        return $vars;
    }

    public static function ajaxSearch($criteria, $attribute, $search) {
        $criteria->andWhere(['LIKE', $attribute, $search]);

        return $criteria;
    }

    public function load($data, $formName = null)
    {
        $res = parent::load($data, $formName);

        $options = static::getOptions();
        foreach($options['fields'] as $variable => $field) {
            if ($field['type'] == 'file') {
                $upload = UploadedFile::getInstance($this, $variable.'_input');
                if ($upload) {
                    $res = true;
                    $this->{$variable.'_input'} = $upload;
                } else {
                    $upload = UploadedFile::getInstanceByName($variable.'_input');
                    if ($upload) {
                        $res = true;
                        $this->{$variable.'_input'} = $upload;
                    }
                }
            }
        }

        return $res;
    }

    public function beforeSave($insert)
    {
        $options = static::getOptions();
        foreach($options['fields'] as $variable => $field) {
            // IMAGE/FILE
            $variableToDel = $variable . '_del';
            $variableInput = $variable . '_input';
            if ($field['type'] == 'file') {
                if ($this->$variableToDel !== 0) {
                    $this->$variable = '';
                } elseif (is_a($this->$variableInput, 'yii\\web\\UploadedFile')) {
                    $savePath = Yii::getAlias('@webroot') . $field['savePath'];
                    if (!file_exists($savePath)) FileHelper::createDirectory($savePath);

                    $safeFileName = SystemHelper::safeFileName($savePath, TextHelper::translit($this->$variableInput->name));

                    $this->$variableInput->saveAs($savePath . '/' . $safeFileName);
                    $this->$variable = $field['savePath'] . '/' . $safeFileName;

                    $this->$variableInput = 0;
                } elseif (!empty($this->$variableInput)) {
                    $savePath = Yii::getAlias('@webroot') . $field['savePath'];
                    if (!file_exists($savePath)) FileHelper::createDirectory($savePath);

                    $fileName = end(explode('/', $this->$variableInput));
                    $safeFileName = SystemHelper::safeFileName($savePath, TextHelper::translit($fileName));

                    file_put_contents($savePath . '/' . $safeFileName, fopen($this->$variableInput, 'r'));
                    $this->$variable = $field['savePath'] . '/' . $safeFileName;
                    $this->$variableInput = 0;
                }
            }
        }

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        $options = static::getOptions();
        foreach($options['fields'] as $variable => $field) {
            // LINK ItoI
            if (!empty($field['link_table'])) {
                $setVariable = $variable . '_input';
                if ($field['type'] == 'link_IToI' && $this->$setVariable !== false) {
                    Yii::$app->db->createCommand('DELETE FROM {{' . $field['link_table'] . '}} WHERE [[' . $field['link_id1'] . ']]=:value', [
                        'value' => $this->id,
                    ])->execute();

                    if ($this->$setVariable !== 'empty' && is_array($this->$setVariable)) {
                        foreach ($this->$setVariable as $id) {
                            Yii::$app->db->createCommand('INSERT INTO {{' . $field['link_table'] . '}} SET [[' . $field['link_id1'] . ']]=:value1, [[' . $field['link_id2'] . ']]=:value2', [
                                'value1' => $this->id,
                                'value2' => $id,
                            ])->execute();
                        }
                    }
                }
            }
        }

        if ($this->insert_all_locale && $insert) {
            $options = static::getOptions();

            $locale_fields = [];
            if (!empty($options['fields'])) {
                foreach ($options['fields'] as $field_name => $field) {
                    if (!empty($field['locale'])) {
                        $locale_fields[] = $field_name;
                    }
                }
            }

            if (!empty($locale_fields)) {
                $main_language = SystemHelper::Language();
                if ($main_language) {
                    $language_ids = ArrayHelper::getColumn(Language::find()->andWhere(['NOT', ['id' => $main_language->id]])->all(), 'id');
                    $table = static::tableName() . '_locale';

                    foreach ($language_ids as $language_id) {
                        $sql = 'INSERT IGNORE INTO `' . $table . '` (' . implode(', ', $locale_fields) . ', locale_parent_id, language_id) SELECT ' . implode(', ', $locale_fields) . ', locale_parent_id, ' . $language_id . ' AS locale_parent_id FROM `' . $table . '` src_table WHERE src_table.language_id=' . $main_language->id;
                        Yii::$app->db->createCommand($sql)->execute();
                    }
                }
            }
        }

        if ($this->set_update_time)
            SystemSettings::setParam('system', 'update_date', time());

        parent::afterSave($insert, $changedAttributes);
    }

    // Нужно, чтобы сохранял как локальные так и удаленные файлы
    public function setFile_attribute($attribute, $imagePath, $copyFile = true) {
        $options = static::getOptions();
        $field = $options['fields'][$attribute];

        $savePath = Yii::getAlias('@webroot') . $field['savePath'];
        if (!file_exists($savePath)) FileHelper::createDirectory($savePath);

        $pi = SystemHelper::full_pathinfo($imagePath);
        $safeFileName = SystemHelper::safeFileName($savePath, TextHelper::translit($pi['basename']));
        if ($copyFile) {
            copy($imagePath, $savePath . '/' . $safeFileName);
        } else {
            rename($imagePath, $savePath . '/' . $safeFileName);
        }
        $this->$attribute = $field['savePath'] . '/' . $safeFileName;
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        return parent::save($runValidation, $attributeNames);
    }

    public function getAttributeLabelWithRequired($attribute, $template = ' *') {
        return $this->getAttributeLabel($attribute) . ($this->isAttributeRequired($attribute)?$template:'');
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'language_filled' => 'Языки',
        ]);
    }

    public function controllerSave() {
        return $this->save();
    }

    public function controllerDelete() {
        return $this->delete();
    }

    protected function saveLinkMany2Many($table, $attribute, $modelColumn, $targetColumn) {
        $db = Yii::$app->db->createCommand();
        $batch = [];
        foreach($this->{$attribute} as $value) {
            $batch[] = [
                $modelColumn => $this->id,
                $targetColumn => $value,
            ];
        }
        $db->delete($table, [$modelColumn => $this->id])->execute();
        $db->batchInsert($table, [$modelColumn, $targetColumn], $batch)->execute();
    }

    public function getAdmin_label() {
        return $this->title;
    }

    public static function getLabel($case = 'И', $multiple = false) {
        $label = static::$model_title;

        return $label;
        //return SystemMorpher::getWord($options['label'], $case, $multiple);
    }

    public static function getLabelTemplate($template = '[content]', $case = 'И', $multiple = false) {
        $label = static::$model_title;

        return str_replace(['[content]', '[Content]'], [$label, $label], $template);
        //return SystemMorpher::getWordTemplate($options['label'], $template, $case, $multiple);
    }

    public function validateName($attribute, $params, $validator = false) {
        if (preg_match('/[0-9]/', $this->$attribute)) {
            $this->addError($attribute, 'Поле «'.$this->getAttributeLabel($attribute).'» не должно иметь цифр');
        }
    }

    public function validateLatin($attribute, $params, $validator = false) {
        if (preg_match('/[а-яА-ЯёЁ]/', $this->$attribute)) {
            $this->addError($attribute, 'Поле «'.$this->getAttributeLabel($attribute).'» не должно содержать кириллических символов');
        }
    }

    public function validateCheckSpam($attribute, $params, $validator = false) {
        $res = false;
        if (strpos($this->$attribute, '/') !== false) $res = true;
        if ($this->$attribute != strip_tags($this->$attribute)) $res = true;
        if (preg_match('/https?:\/\//', $this->$attribute)) $res = true;
        if (strpos($this->$attribute, '@') !== false) $res = true;

        if ($res) {
            $this->addError($attribute, 'В поле «'.$this->getAttributeLabel($attribute).'» ошибка');
        }
    }

    public function validateAllRequired($attribute_name, $params)
    {
        $full = false;
        $fieldNames = [];

        foreach($params as $attribute) {
            $full = $full || !empty($this->{$attribute});
            $fieldNames[] = '«' . $this->getAttributeLabel($attribute) . '»';
        }
        if (!$full) {
            $this->addError($attribute_name, 'Необходимо заполнить хотя бы одно из полей ' . implode(', ', $fieldNames));
            return false;
        }

        return true;
    }
}

class CActiveQuery extends ActiveQuery {
    public function init()
    {
        parent::init();
    }

    public function active_by_dates() {
        $alias = $this->getTableNameAndAlias();
        $alias = $alias[1];

        $this->andWhere(['OR', [$alias.'.active_from' => null], [$alias.'.active_from' => ''], [$alias.'.active_from' => 0], ['<=', $alias.'.active_from', date('Y-m-d H:i:s')]]);
        $this->andWhere(['OR', [$alias.'.active_to' => null], [$alias.'.active_to' => ''], [$alias.'.active_to' => 0], ['>=', $alias.'.active_to', date('Y-m-d H:i:s')]]);

        return $this;
    }

    public function published() {
        $alias = $this->getTableNameAndAlias();
        $alias = $alias[1];

        $cn = $this->modelClass;
        $options = $cn::getOptions();
        if (!empty($options['fields']['public']['locale'])) $alias .= '_locale';

        $this->andWhere(['>=', $alias . '.public', 1]);
        
        return $this;
    }
    public function ordered($direct = 'ASC') {
        $alias = $this->getTableNameAndAlias();
        $this->orderBy($alias[1] . '.weight '.$direct);
        return $this;
    }
    public function orderByString($sort) {
        $sorts = explode('-', $sort);
        if (count($sorts) == 1) {
            $this->orderBy($sorts[0] . ' ASC');
        } else {
            $this->orderBy($sorts[1] . ' DESC');
        }
        return $this;
    }
    public function random() {
        $this->addOrderBy('rand()');
        return $this;
    }

    public function oneOrNotFound($db = null)
    {
        $res = parent::one($db);
        if (!$res) throw new NotFoundHttpException();

        return $res;
    }

    public function search_in_fields($search_text, $search_fields, $having = false) {
        if (!is_array($search_fields)) $search_fields = [$search_fields];
        $parts = preg_split('/\s+/', trim($search_text));
        $orWhere = ['OR'];
        foreach ($search_fields as $search_field) {
            $partWhere = ['AND'];
            foreach ($parts as $part) {
                $partWhere[] = ['LIKE', $search_field, $part];
            }
            $orWhere[] = $partWhere;
        }

        if ($having) {
            $this->andHaving($orWhere);
        } else {
            $this->andWhere($orWhere);
        }

        return $this;
    }
}

?>
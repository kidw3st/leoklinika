<?php
    namespace app\behaviors\base;

    use yii\base\Behavior;
    use yii\db\ActiveRecord;

    class HandleBehavior extends Behavior
    {
        public $attributes = ['handle' => 'title'];
        public $tree_attributes = [];//['handle_tree' => 'handle',];

        public function events()
        {
            return [
                ActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
                ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSave',
                ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
                ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
            ];
        }

        public function beforeSave($event)
        {

        }

        public function afterSave($event)
        {
            $className = $this->owner->className();
            foreach($this->attributes as $attribute => $trans) {
                if ($this->owner->{$attribute} == '' && $this->owner->{$trans} != '') {
                    $this->owner->{$attribute} = HandleBehavior::cyrillicToLatin($this->owner->{$trans}, 200, true);

                    $checkHandle = $className::find()->where([$attribute => $this->owner->{$attribute}])->all();
                    if ($checkHandle) {
                        $this->owner->{$attribute} .= '-' . $this->owner->id;
                    }

                    $this->owner->save(false);
                }
            }

            foreach($this->tree_attributes as $tree_attribute => $attribute) {
                $this->owner->setTreeHandle($tree_attribute, $attribute);
            }
        }

        private static function cyrillicToLatin($text, $maxLength, $toLowCase)
        {
            $dictionary = array(
                'й' => 'i',
                'ц' => 'c',
                'у' => 'u',
                'к' => 'k',
                'е' => 'e',
                'н' => 'n',
                'г' => 'g',
                'ш' => 'sh',
                'щ' => 'shch',
                'з' => 'z',
                'х' => 'h',
                'ъ' => '',
                'ф' => 'f',
                'ы' => 'y',
                'в' => 'v',
                'а' => 'a',
                'п' => 'p',
                'р' => 'r',
                'о' => 'o',
                'л' => 'l',
                'д' => 'd',
                'ж' => 'zh',
                'э' => 'e',
                'ё' => 'e',
                'я' => 'ya',
                'ч' => 'ch',
                'с' => 's',
                'м' => 'm',
                'и' => 'i',
                'т' => 't',
                'ь' => '',
                'б' => 'b',
                'ю' => 'yu',

                'Й' => 'I',
                'Ц' => 'C',
                'У' => 'U',
                'К' => 'K',
                'Е' => 'E',
                'Н' => 'N',
                'Г' => 'G',
                'Ш' => 'SH',
                'Щ' => 'SHCH',
                'З' => 'Z',
                'Х' => 'X',
                'Ъ' => '',
                'Ф' => 'F',
                'Ы' => 'Y',
                'В' => 'V',
                'А' => 'A',
                'П' => 'P',
                'Р' => 'R',
                'О' => 'O',
                'Л' => 'L',
                'Д' => 'D',
                'Ж' => 'ZH',
                'Э' => 'E',
                'Ё' => 'E',
                'Я' => 'YA',
                'Ч' => 'CH',
                'С' => 'S',
                'М' => 'M',
                'И' => 'I',
                'Т' => 'T',
                'Ь' => '',
                'Б' => 'B',
                'Ю' => 'YU',

                '\-' => '-',
                '\s' => '-',

                '[^a-zA-Z0-9\-]' => '',

                '[-]{2,}' => '-',
            );

            foreach ($dictionary as $from => $to)
            {
                $text = mb_ereg_replace($from, $to, $text);
            }

            $text = mb_substr($text, 0, $maxLength, \Yii::$app->charset);
            if ($toLowCase)
            {
                $text = mb_strtolower($text, \Yii::$app->charset);
            }

            return trim($text, '-');
        }
    }
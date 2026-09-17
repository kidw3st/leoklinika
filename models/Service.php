<?php
namespace app\models;

use Yii;
use app\models\parents\ServiceParent;

/**
 * Class Service
 * @package app\models
 *
 * @property string $selfUrl
 * @property Service[] $subsections
 * @property array $pricelist
 */
class Service extends ServiceParent
{
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

    public static function getOptions($model = false)
    {
        $res = parent::getOptions($model);

        return $res;
    }

    public static function indexUrl() {
        return Yii::$app->urlManager->createUrl(['service/index']);
    }

    public function getSelfUrl() {
        return Yii::$app->urlManager->createUrl(['service/detail', 'handle' => $this->handle_tree]);
    }

    public function getSubsections() {
        $res = $this->children(1)->published()->all();
        $this->populateRelation('subsections', $res);

        return $res;
    }

    public function getPricelist($member = false, $service_ids = false, $search = false) {
        $res = [
            'name' => $this->title,
            'prices' => $this->prices_real,
            'children' => [],
        ];

        if ($search) {
            foreach ($res['prices'] as $k => $price) {
                if (strpos(mb_strtolower($price->title), mb_strtolower($search)) === false) {
                    unset($res['prices'][$k]);
                }
            }
        }

        if ($member && !in_array($member->id, $this->members_input) || !empty($service_ids) && (!in_array($this->id, $service_ids))) {
            $res = [
                'name' => $this->title,
                'prices' => false,
                'children' => [],
            ];
        }

        if ($this->subsections) {
            foreach ($this->subsections as $subsection) {
                $ch = $subsection->getPricelist($member, $service_ids, $search);
                if (!empty($ch)) {
                    $res['children'][] = $ch;
                }
            }
        }

        if (!empty($res['prices']) || !empty($res['children']))
            return $res;

        return [];
    }

    public static function find_base() {
        return Service::find()->where(['OR', ['=', 'depth', 1], ['<>', 'icon', '']]);
    }
}
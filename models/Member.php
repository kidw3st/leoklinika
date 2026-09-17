<?php
namespace app\models;

use Yii;
use app\models\parents\MemberParent;

/**
 * Class Member
 * @package app\models
 *
 * @property string $selfUrl
 * @property string $blogUrl
 * @property string $description
 * @property array $specials_arr
 * @property array $pricelist
 * @property float $min_price
 */
class Member extends MemberParent
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
        return Yii::$app->urlManager->createUrl(['members/index']);
    }

    public function getSelfUrl() {
        return Yii::$app->urlManager->createUrl(['members/detail', 'handle' => $this->handle]);
    }

    public function getBlogUrl() {
        return Yii::$app->urlManager->createUrl(['blog/index', 'type' => 'articles', 'member' => $this->id]);
    }

    public function getDescription() {
        $res = [];

        if (!empty($this->position)) $res[] = $this->position;
        if (!empty($this->education)) $res[] = $this->education;

        return implode(', ', $res);
    }

    public function getSpecials_arr() {
        $items = explode("\r\n", $this->specials);

        $res = [];
        foreach ($items as $item) {
            $item = trim($item);
            if (!empty($item)) $res[] = $item;
        }

        return $res;
    }

    public function getPricelist() {
        $service = Service::find_base()->orderBy('lft ASC')->one();

        return $service->getPricelist($this);
    }

    public function getMin_price() {
        $prices = Yii::$app->db->createCommand("SELECT service_price.price FROM service_price LEFT JOIN service2member ON (service2member.server_id = service_price.service_id) WHERE service2member.member_id = " . $this->id . " ORDER BY price ASC")->queryOne();
        if (!empty($prices['price'])) return $prices['price'];

        return 0;
    }

    public function getReviews_real() {
        $res = $this->getReviews()->published()->orderBy('date DESC')->all();
        $this->populateRelation('reviews_real', $res);

        return $res;
    }
}
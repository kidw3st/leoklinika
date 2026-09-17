<?php

namespace app\helpers\base;

use Yii;

class SeoHelper {
    public static function getSeoFields($item, $title_attribute = 'title', $description_attribute = 'description', $image_attribute = 'image') {
        $seo_title = $item->seo_title;
        $seo_description = $item->seo_description;
        $seo_keywords = $item->seo_keywords;

        if (empty($seo_title) && !empty($item->{$title_attribute})) $seo_title = $item->{$title_attribute};
        if (empty($seo_description) && !empty($item->{$description_attribute})) $seo_description = $item->{$description_attribute};

        $og_title = $item->og_title;
        $og_description = $item->og_description;
        $og_img = SystemHelper::AbsoluteLink($item->og_image);

        if (empty($og_title)) $og_title = $seo_title;
        if (empty($og_description)) $og_description = $seo_description;
        if (empty($og_img) && !empty($item->{$image_attribute})) $og_img = SystemHelper::AbsoluteLink($item->{$image_attribute});

        return [
            'seo_title' => $seo_title,
            'seo_description' => $seo_description,
            'seo_keywords' => $seo_keywords,
            'og_title' => $og_title,
            'og_description' => $og_description,
            'og_img' => $og_img,
        ];
    }
}

?>
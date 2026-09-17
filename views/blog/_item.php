<?php
use app\helpers\base\TextHelper;

/**
 * @var \app\models\Article $item
 */

?>

<div class="blog__item">
    <a class="blog__link" href="<?=$item->selfUrl?>">
        <div class="blog__img">
            <img src="<?=TextHelper::ImgUrl($item->image_obj->doCrop(440, 296))?>" alt="<?=TextHelper::Alt($item->title)?>">
        </div>
        <div class="blog__item__title bodytext_n_strong"><?=$item->title?></div>
        <span class="blog__data bodytext_m"><?=$item->date_obj->format('d.m.Y')?></span>
    </a>
</div>
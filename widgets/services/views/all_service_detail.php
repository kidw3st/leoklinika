<?php
use app\assets\PjaxAsset;
use app\components\base\Pagination;
use app\helpers\base\SystemHelper;
use app\helpers\base\TextHelper;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var string $link_all
 * @var \app\models\ServiceTag $tags
 * @var string $current_tag
 * @var string $current_type
 * @var \app\models\Service[] $services
 * @var string $pjax_id
 * @var Pagination $pages
 * @var array $options
 */

PjaxAsset::register($this);
?>

<section class="services">
    <div class="container" id="<?=$pjax_id?>">
        <div class="services__head">
            <h2 class="services__title "><?=$title?></h2>
        </div>

        <div class="services__list">
            <?php foreach ($services as $service) { ?>
                <a href="<?=$service->selfUrl?>" class="services__item">
                    <div class="services__item__block">
                        <p class="services__item__title bodytext_n_strong"><?=$service->title?></p>
                        <p class="services__item__pseudolink">
                            <span>Смотреть</span>
                            <svg class="icon">
                                <use xlink:href="#icon-arrow"></use>
                            </svg>
                        </p>
                    </div>

                    <div class="services__item__image-wrapper">
                        <img src="<?=TextHelper::ImgUrl($service->icon_obj->doCrop(60, 60))?>" alt="<?=TextHelper::Alt($service->title)?>" class="services__item__image" />
                    </div>
                </a>
            <?php } ?>
        </div>

        <?=$pages->draw('//components/pager_more', 2, ['pjax_block' => '#' . $pjax_id, 'class' => (!empty($options['pager_class'])?$options['pager_class']:'services-general__services__btn btn btn_secondary')])?>
    </div>
</section>
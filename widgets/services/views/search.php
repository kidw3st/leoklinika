<?php
use app\assets\PjaxAsset;
use app\components\base\Pagination;
use app\helpers\base\SystemHelper;
use app\models\SystemSettings;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var string $link_all
 * @var \app\models\ServiceTag $tags
 * @var string $current_tag
 * @var string $current_type
 * @var \app\models\Service $services
 * @var string $pjax_id
 * @var Pagination $pages
 * @var array $options
 * @var array $filter
 * @var array $current_filter
 * @var array $current_filter_objects
 * @var string $search
 * @var string $search_title
 */

PjaxAsset::register($this);
?>

<section class="search-block search-block_services">
    <div class="container" id="<?=$pjax_id?>">
        <div class="search-block__wrapper">
            <div class="search-block__top _toggle<?=!empty($current_filter)?' _toggle_active':''?>">
                <form class="search-block__form" action="<?=SystemHelper::LanguageLink(Yii::$app->request->url)?>" data-pjax-block="#<?=$pjax_id?>" method="get">
                    <input class="search-block__form__input" name="search" type="text" value="<?=$search?>" placeholder="Офтальмолог, Узи..."<?=empty($search)?' required':''?> />
                    <button class="search-block__form__btn search-block__form__btn_search" type="submit">
                        <svg class="icon icon_search">
                            <use xlink:href="#icon-search"></use>
                        </svg>
                    </button>
                    <button class="search-block__form__btn search-block__form__btn_close" type="reset">
                        <svg class="icon icon_close">
                            <use xlink:href="#icon-close"></use>
                        </svg>
                    </button>
                    <?php if (!empty($current_filter_objects['direction'])) { ?>
                        <input type="hidden" name="filter[direction]" value="<?=$current_filter_objects['direction']->id?>" />
                    <?php } ?>
                    <?php if (!empty($current_filter_objects['filial'])) { ?>
                        <input type="hidden" name="filter[filial]" value="<?=$current_filter_objects['filial']->id?>" />
                    <?php } ?>
                </form>
                <button class="search-block__parameters _toggle__button">
                    <svg class="icon icon_open">
                        <use xlink:href="#icon-parameters"></use>
                    </svg>
                    <svg class="icon icon_close">
                        <use xlink:href="#icon-close"></use>
                    </svg>
                </button>
                <div class="search-block__more _toggle__container">
                    <?php if(!empty($filter['directions'])) { ?>
                        <div class="search-block__dropdown dropdown">
                            <button class="dropdown__btn">
                                <?php if (empty($current_filter_objects['direction'])) { ?>
                                    <span class="dropdown__current bodytext_m">Выберите направление</span>
                                <?php } else { ?>
                                    <span class="dropdown__current bodytext_m"><?=$current_filter_objects['direction']->title?></span>
                                <?php } ?>
                                <svg class="icon icon_close">
                                    <use xlink:href="#icon-arrow3"></use>
                                </svg>
                            </button>
                            <ul class="dropdown__list">
                                <?php foreach ($filter['directions'] as $item) { ?>
                                    <li class="dropdown__item" data-value="<?=$item->id?>">
                                        <a href="<?=Url::current(['filter' => ['direction' => $item->id]])?>" data-pjax-block="#<?=$pjax_id?>" class="dropdown__link bodytext_m"><?=$item->title?></a>
                                    </li>
                                <?php } ?>
                            </ul>
                            <input type="text" name="select" value="krsk" class="dropdown__input_hidden">
                        </div>
                    <?php } ?>
                    <?php if(!empty($filter['filials'])) { ?>
                        <div class="search-block__dropdown dropdown">
                            <button class="dropdown__btn">
                                <?php if (empty($current_filter_objects['filial'])) { ?>
                                    <span class="dropdown__current bodytext_m">Выберите клинику</span>
                                <?php } else { ?>
                                    <span class="dropdown__current bodytext_m"><?=$current_filter_objects['filial']->title?></span>
                                <?php } ?>
                                <svg class="icon icon_close">
                                    <use xlink:href="#icon-arrow3"></use>
                                </svg>
                            </button>
                            <ul class="dropdown__list">
                                <?php foreach ($filter['filials'] as $item) { ?>
                                    <li class="dropdown__item" data-value="<?=$item->id?>">
                                        <a href="<?=Url::current(['filter' => ['filial' => $item->id]])?>" data-pjax-block="#<?=$pjax_id?>" class="dropdown__link bodytext_m"><?=$item->title?></a>
                                    </li>
                                <?php } ?>
                            </ul>
                            <input type="text" name="select" value="krsk" class="dropdown__input_hidden">
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="search-block__bottom">
                <p class="search-block__title megatext_s_strong"><?=$search_title?></p>
                <?php if (!empty($services)) { ?>
                    <ul class="search-block__list">
                        <?php foreach ($services as $service) { ?>
                            <li class="search-block__item">
                                <a href="<?=$service->selfUrl?>" class="search-block__link bodytext_s_strong"><?=$service->title?></a>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } else { ?>
                    <p><?=SystemSettings::getParam('service', 'empty_text', 'Услуги не найдены')?></p>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
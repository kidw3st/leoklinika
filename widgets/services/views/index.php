<?php
use app\assets\PjaxAsset;
use app\helpers\base\SystemHelper;
use app\helpers\base\TextHelper;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var string $link_all
 * @var \app\models\ServiceTag $tags
 * @var string $current_tag
 * @var string $current_type
 * @var \app\models\Service $services
 * @var string $pjax_id
 * @var array $options
 */

PjaxAsset::register($this);
?>

<div class="container" id="<?=$pjax_id?>">
    <div class="services__head">
        <h2 class="services__title <?=$this->context->title_class?>"><?=$title?></h2>
        <a class="services__link btn btn_link_arrow bodytext_n_strong _desktop" href="<?=$link_all?>"><?=!empty($options['link_title'])?$options['link_title']:'Смотреть все услуги'?></a>
    </div>
    <div class="services__wrapper">
        <div class="filter services__filter">
            <div class="filter__list">
                <a href="<?=Url::current(['tag' => null])?>" data-pjax-block="#<?=$pjax_id?>" class="filter__item bodytext_m_strong<?=empty($current_tag)?' _active':''?>">Все</a>

                <?php foreach ($tags as $k => $tag) { ?>
                    <a href="<?=Url::current(['tag' => $tag->id])?>" data-pjax-block="#<?=$pjax_id?>" class="filter__item bodytext_m_strong<?=($current_tag==$tag->id)?' _active':''?>"><?=$tag->title?></a>
                <?php } ?>
            </div>
        </div>
        <form action="<?=SystemHelper::LanguageLink(Yii::$app->request->url)?>" class="switch services__switch" data-pjax-block="#<?=$pjax_id?>" method="GET">
            <span class="switch__text bodytext_l_strong<?=($current_type=='adult')?' _active':''?>" data-value="adult" data-autosubmit>Врачи и услуги</span>
            <label class="switch__wrapper">
                <input type="checkbox" name="type" value="<?=$current_type=='adult'?'child':'adult'?>"<?=$current_type=='child'?' checked':''?> data-autosubmit>
                <span class="switch__slider"></span>
            </label>
            <span class="switch__text bodytext_l_strong<?=($current_type=='child')?' _active':''?>" data-value="child" data-autosubmit>Программы и чекапы</span>
        </form>
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
    <a class="services__link btn btn_link_arrow bodytext_n_strong _mobile" href="<?=$link_all?>"><?=!empty($options['link_title'])?$options['link_title']:'Смотреть все услуги'?></a>
</div>
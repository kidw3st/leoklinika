<?php
use app\assets\PjaxAsset;
use app\components\base\Pagination;
use app\helpers\base\SystemHelper;
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
 */

PjaxAsset::register($this);
?>

<section class="services-general__services">
    <div class="decor-spots">
        <div class="decor-spots__item"></div>
        <div class="decor-spots__item"></div>
        <div class="decor-spots__item"></div>
    </div>
    <div class="container" id="<?=$pjax_id?>">
        <div class="services-general__services__head">
            <h2 class="services-general__services__title"><?=$title?></h2>
            <form action="<?=SystemHelper::LanguageLink(Yii::$app->request->url)?>" class="switch services__switch" data-pjax-block="#<?=$pjax_id?>" method="GET">
                <span class="switch__text bodytext_l_strong<?=($current_type=='adult')?' _active':''?>" data-value="adult" data-autosubmit>Врачи и услуги</span>
                <label class="switch__wrapper">
                    <input type="checkbox" name="type" value="<?=$current_type=='adult'?'child':'adult'?>"<?=$current_type=='child'?' checked':''?> data-autosubmit>
                    <span class="switch__slider"></span>
                </label>
                <span class="switch__text bodytext_l_strong<?=($current_type=='child')?' _active':''?>" data-value="child" data-autosubmit>Программы и чекапы</span>
            </form>
        </div>
        <ul class="services-general__services__list">
            <?php foreach ($services as $service) { ?>
                <li class="services-general__services__item">
                    <a href="<?=$service->selfUrl?>" class="services-general__services__link bodytext_l"><?=$service->title?></a>
                </li>
            <?php } ?>
        </ul>
        <?=$pages->draw('//components/pager_more', 2, ['pjax_block' => '#' . $pjax_id, 'class' => 'services-general__services__btn btn btn_secondary'])?>
    </div>
</section>
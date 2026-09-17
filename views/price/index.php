<?php
use app\helpers\base\TextHelper;
use app\models\forms\RequestAppointmentForm;
use app\models\SystemSettings;
use yii\helpers\Url; 

/* @var $this \yii\web\View */
/* @var $pricelist array */
/* @var $root_services \app\models\Service[] */
/* @var $popular_services \app\models\Service[] */
/* @var $actions  */
/* @var $title_seo  */
/* @var $text_seo  */
/* @var $text_spoiler  */
/* @var $tag integer  */
/* @var $filter_variants array */
/* @var $current_filter array|mixed */
/* @var $search string */
?>

<?=$this->render('//components/_breadcrumbs', ['breadcrumbs' => $this->context->breadcrumbs])?>  
<?php
$price_sourse = SystemSettings::getParam('service', 'price_medflex_token');
?>    
<div class="container">
    <h2 class="price__title"><?=$this->context->h1title?></h2>
</div>  
<?php if (!empty($price_sourse)) { ?>
<div id="pricelist-block">
  <div class="container">
    <div id="medflexPricesWidgetData" data-src="https://booking.medflex.ru?user=<?=$price_sourse?>"></div> 
    <script defer src="https://booking.medflex.ru/components/prices/prices_widget.js" charset="utf-8"></script>
  </div>
</div> 
<?php } else { ?>  
<div id="pricelist-block">
    <section class="search-block search-block_services">
        <div class="container">
            <div class="search-block__wrapper">
                <div class="search-block__top _toggle<?=(!empty($current_filter['direction']) || !empty($current_filter['filial']))?' _toggle_active':''?>">
                    <form class="search-block__form" action="<?=Yii::$app->urlManager->createUrl(['price/index'])?>" method="get" data-pjax-block="#pricelist-block">
                        <input class="search-block__form__input" name="search" value="<?=$search?>" type="text" placeholder="Офтальмолог, Узи..."<?=empty($search)?' required':''?> />
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
                        <?php if (!empty($current_filter['direction'])) { ?>
                            <input type="hidden" name="filter[direction]" value="<?=$current_filter['direction']?>" />
                        <?php } ?>
                        <?php if (!empty($current_filter['filial'])) { ?>
                            <input type="hidden" name="filter[filial]" value="<?=$current_filter['filial']?>" />
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
                        <?php foreach ($filter_variants as $k => $filter_variant) { ?>
                            <div class="search-block__dropdown dropdown">
                                <button class="dropdown__btn">
                                    <?php if (empty($current_filter[$k])) { ?>
                                        <a href="<?=Url::current(['filter' => [$k => null]])?>" data-pjax-block="#pricelist-block" class="dropdown__current bodytext_m"><?=$filter_variant['title']?></a>
                                    <?php } else { ?>
                                        <a href="<?=Url::current(['filter' => [$k => null]])?>" data-pjax-block="#pricelist-block" class="dropdown__current bodytext_m"><?=$filter_variant['items'][$current_filter[$k]]->title?></a>
                                    <?php } ?>
                                    <svg class="icon icon_close">
                                        <use xlink:href="#icon-arrow3"></use>
                                    </svg>
                                </button>
                                <ul class="dropdown__list">
                                    <?php foreach ($filter_variant['items'] as $item) { ?>
                                        <li class="dropdown__item" data-value="<?=$item->id?>">
                                            <a href="<?=Url::current(['filter' => [$k => $item->id]])?>" data-pjax-block="#pricelist-block" class="dropdown__link bodytext_m"><?=$item->title?></a>
                                        </li>
                                    <?php } ?>
                                </ul>
                                <input type="text" name="select" value="krsk" class="dropdown__input_hidden">
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <?php if ($popular_services) { ?>
                    <div class="search-block__bottom">
                        <p class="search-block__title megatext_s_strong">Популярные услуги</p>
                        <ul class="search-block__list">
                            <?php foreach ($popular_services as $service) { ?>
                                <li class="search-block__item">
                                    <a href="<?=$service->selfUrl?>" class="search-block__link bodytext_s_strong"><?=$service->title?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <section class="pricelist">
        <div class="container">
            <div class="pricelist__filter"></div>

            <?php if ($root_services) { ?>
                <div class="filter">
                    <div class="filter__list">
                        <a href="<?=Url::current(['tag' => null])?>" class="filter__item bodytext_m_strong<?=empty($tag)?' _active':''?>" data-pjax-block="#pricelist-block">Все</a>
                        <?php foreach ($root_services as $service) { ?>
                            <a href="<?=Url::current(['tag' => $service->id])?>" class="filter__item bodytext_m_strong<?=($service->id==$tag)?' _active':''?>" data-pjax-block="#pricelist-block"><?=$service->title?></a>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
            <div class="pricelist__wrapper">
                <?=$this->render('//service/_pricelist_accordion', ['pricelist' => $pricelist])?>
            </div>

        </div>
    </section>
</div>
<?php } ?>
<?=$this->render('//components/form_inline', [
    'form_type' => 'appointment_pricelist_index',
    'form_image' => '',
    'form_video_id' => '',
    'pjax_id' => 'appointment_pricelist_index',
    'model' => new RequestAppointmentForm(),
    'form_class' => RequestAppointmentForm::class,
    'template' => 'consult',
    'section_class' => 'consultation_wide',
    'options' => [
        'title_tag' => 'h4',
    ],
])?>

<?=$this->render('//components/actions', ['actions' => $actions, 'title' => 'Специальные предложения', 'title_class' => ''])?>

<section class="seo wysiwyg">
    <div class="container">
        <div class="seo__wrapper _toggle">
            <?php if(!empty($title_seo)) { ?>
                <h1 class="seo__title"><?=$title_seo?></h1>
            <?php } ?>
            <?php if (!empty($text_seo)) { ?>
                <?=TextHelper::redactorText($text_seo, ['<p>' => '<p class="seo__text bodytext_l">'])?>
            <?php } ?>
            <?php if(!empty($text_spoiler)) { ?>
                <div class="_toggle__container"><?=$text_spoiler?></div>
                <button class="seo__btn _toggle__button">
                    <span class="seo__btn__more">Показать ещё</span>
                    <span class="seo__btn__less">Свернуть</span>
                    <svg class="icon" width="24" height="24">
                        <use xlink:href="#icon-arrow1"></use>
                    </svg>
                </button>
            <?php } ?>
        </div>
    </div>
</section>
<?php
use app\helpers\base\TextHelper;
use app\models\forms\RequestAppointmentForm;
use yii\helpers\Url;
use app\models\SystemSettings;

/* @var $this \yii\web\View */
/* @var $members \app\models\Member[] */
/* @var $all_members \app\models\Member[] */
/* @var $actions \app\models\Action[] */
/* @var $title_seo string */
/* @var $text_seo string */
/* @var $text_spoiler string */
/* @var $empty_text string */
/* @var $sort string */
/* @var $sort_list array */
/* @var $search string */
/* @var $pages \app\components\base\Pagination */
/* @var $filter_variants array */
?>

<?=$this->render('//components/_breadcrumbs', ['breadcrumbs' => $this->context->breadcrumbs])?>
<?php
$medflex_token = SystemSettings::getParam('common', 'medflex_token');
?>
<div class="container">
    <h2 class="team__title"><?=$this->context->h1title?></h2>
</div>

<div id="members-block">
    <section class="search-block search-block_team">
        <div class="container">
            <div class="search-block__wrapper">
                <div class="search-block__top">
                    <form class="search-block__form" action="<?=Yii::$app->urlManager->createUrl(['members/index'])?>" method="get" data-pjax-block="#members-block">
                        <input class="search-block__form__input" name="search" value="<?=$search?>"  type="text" placeholder="Поиск по направлению врача или фамилии"<?=empty($search)?' required':''?> />
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
                        <?php if (!empty($current_filter['qualify'])) { ?>
                            <input type="hidden" name="filter[qualify]" value="<?=$current_filter['qualify']?>" />
                        <?php } ?>
                        <?php if (!empty($current_filter['type'])) { ?>
                            <input type="hidden" name="filter[type]" value="<?=$current_filter['type']?>" />
                        <?php } ?>
                        <?php if (!empty($sort)) { ?>
                            <input type="hidden" name="sort" value="<?=$sort?>" />
                        <?php } ?>
                    </form>
                </div>
                <div class="search-block__bottom">
                    <div class="search-block__bottom__wrapper">
                        <?php foreach ($filter_variants as $k => $filter_variant) { ?>
                            <div class="search-block__dropdown dropdown">
                                <button class="dropdown__btn">
                                    <?php if (empty($current_filter[$k])) { ?>
                                        <span class="dropdown__current bodytext_m"><?=$filter_variant['title']?></span>
                                    <?php } else { ?>
                                        <span class="dropdown__current bodytext_m"><?=$filter_variant['items'][$current_filter[$k]]->title?></span>
                                    <?php } ?>
                                    <svg class="icon icon_close">
                                        <use xlink:href="#icon-arrow3"></use>
                                    </svg>
                                </button>
                                <ul class="dropdown__list">
                                    <?php foreach ($filter_variant['items'] as $item) { ?>
                                        <li class="dropdown__item" data-value="<?=$item->id?>">
                                            <a href="<?=Url::current(['filter' => [$k => $item->id]])?>" data-pjax-block="#members-block" class="dropdown__link bodytext_m"><?=$item->title?></a>
                                        </li>
                                    <?php } ?>
                                </ul>
                                <input type="text" name="select" value="krsk" class="dropdown__input_hidden">
                            </div>
                        <?php } ?>
                    </div>

                    <form action="<?=Yii::$app->urlManager->createUrl(['members/index'])?>" class="switch services__switch" data-pjax-block="#members-block" method="GET">
                        <span class="switch__text bodytext_l_strong<?=($current_filter['type']=='adult')?' _active':''?>" data-value="adult" data-autosubmit>Врачи и услуги</span>
                        <label class="switch__wrapper">
                            <input type="checkbox" name="filter[type]" value="<?=$current_filter['type']=='adult'?'child':'adult'?>"<?=$current_filter['type']=='child'?' checked':''?> data-autosubmit>
                            <span class="switch__slider"></span>
                        </label>
                        <span class="switch__text bodytext_l_strong<?=($current_filter['type']=='child')?' _active':''?>" data-value="child" data-autosubmit>Программы и чекапы</span>
                        <?php if (!empty($current_filter['direction'])) { ?>
                            <input type="hidden" name="filter[direction]" value="<?=$current_filter['direction']?>" />
                        <?php } ?>
                        <?php if (!empty($current_filter['filial'])) { ?>
                            <input type="hidden" name="filter[filial]" value="<?=$current_filter['filial']?>" />
                        <?php } ?>
                        <?php if (!empty($current_filter['qualify'])) { ?>
                            <input type="hidden" name="filter[qualify]" value="<?=$current_filter['qualify']?>" />
                        <?php } ?>
                        <?php if (!empty($search)) { ?>
                            <input type="hidden" name="search" value="<?=$search?>" />
                        <?php } ?>
                        <?php if (!empty($sort)) { ?>
                            <input type="hidden" name="sort" value="<?=$sort?>" />
                        <?php } ?>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="team__doctors">
        <div class="container">
            <?php if($members) { ?>
                <div class="team__doctors__dropdown dropdown">
                    <button class="dropdown__btn">
                        <a href="#" class="dropdown__current bodytext_m"><?=empty($sort)?'по умолчанию':$sort_list[$sort]?></a>
                        <svg class="icon icon_close">
                            <use xlink:href="#icon-arrow3"></use>
                        </svg>
                    </button>
                    <ul class="dropdown__list">
                        <li class="dropdown__item<?=empty($sort)?' _selected':''?>" data-value="default">
                            <a href="<?=Url::current(['sort' => null])?>" class="dropdown__link bodytext_m" data-pjax-block="#members-block">по умолчанию</a>
                        </li>
                        <?php foreach ($sort_list as $k => $v) { ?>
                            <li class="dropdown__item<?=($k==$sort)?' _selected':''?>" data-value="<?=$k?>">
                                <a href="<?=Url::current(['sort' => $k])?>" class="dropdown__link bodytext_m" data-pjax-block="#members-block"><?=$v?></a>
                            </li>
                        <?php } ?>
                    </ul>
                    <input type="text" name="select" value="default" class="dropdown__input_hidden">
                </div>

                <div class="decor-spots">
                    <div class="decor-spots__item"></div>
                    <div class="decor-spots__item"></div>
                    <div class="decor-spots__item"></div>
                </div>
                <div class="team__doctors__wrapper">
                    <?php foreach ($members as $member) { ?>
                        <?=$this->render('_item', ['item' => $member, 'medflex_token' => $medflex_token])?>
                    <?php } ?>
                </div>
                <?=$pages->draw('//components/pager_more', 2, ['pjax_block' => '#members-block', 'class' => 'team__doctors__btn btn btn_secondary'])?>
            <?php } else { ?>
                <?=$empty_text?>
            <?php } ?>
        </div>
    </section>
</div>

<?=$this->render('//components/form_inline', [
    'form_type' => 'appointment_member_index',
    'form_image' => '',
    'form_video_id' => '',
    'pjax_id' => 'appointment_members_index',
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

<?php foreach ($all_members as $member) { ?>
    <?php $this->beginBlock('modal-appointment_member_'.$member->id)?>
    <?=$this->render('//components/form_modal', [
        'form_type' => 'appointment_member',
        'form_image' => $member->modal_image,
        'form_video_id' => $member->modal_video_id,
        'modal_id' => 'appointment_member_' . $member->id,
        'pjax_id' => 'appointment_member_' . $member->id,
        'form_class' => RequestAppointmentForm::class,
        'model' => new RequestAppointmentForm(['member_id' => $member->id]),
        'template' => 'form_1',
    ])?>
    <?php $this->endBlock()?>
<?php } ?>
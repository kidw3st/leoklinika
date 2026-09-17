<?php
use app\helpers\base\TextHelper;
use app\models\forms\RequestAppointmentForm;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $actions \app\models\Action[]|array|\yii\db\ActiveRecord[] */
/* @var $intro  */
/* @var $tag bool */
/* @var $tags  */
/* @var $pages \app\components\base\Pagination */
?>

<?=$this->render('//components/_breadcrumbs', ['breadcrumbs' => $this->context->breadcrumbs])?>
<div class="container" id="actions-block">
    <h1 class="promos-general__title"><?=$this->context->h1title?></h1>
    <?=TextHelper::redactorText($intro, ['<p>' => '<p class="promos-general__subtitle bodytext_n">'])?>

    <?php if ($tags) { ?>
        <div class="promos-general__filter">
            <div class="filter__list">
                <a href="<?=Url::current(['page' => null, 'tag' => null])?>" data-pjax-block="#actions-block" class="filter__item bodytext_m_strong<?=empty($current_tag)?' _active':''?>">Все акции</a>
                <?php foreach ($tags as $tag) { ?>
                    <a href="<?=Url::current(['page' => null, 'tag' => $tag->id])?>" data-pjax-block="#actions-block" class="filter__item bodytext_m_strong<?=($tag->id == $current_tag)?' _active':''?>"><?=$tag->title?></a>
                <?php } ?>
            </div>
        </div>
    <?php } ?>

    <div class="promos-general__list">
        <?php foreach ($actions as $action) { ?>
            <div class="promos-general__item">
                <?=$this->render('_item', ['action' => $action])?>
            </div>
        <?php } ?>
    </div>

    <?=$pages_more->draw('//components/pager_more', 2, ['pjax_block' => '#actions-block', 'class' => 'promos-general__btn btn btn_secondary'])?>
    <?=$pages->draw('//components/pager', 2, ['pjax_block' => '#actions-block'])?>
</div>

<?=$this->render('//components/form_inline', [
    'form_type' => 'appointment_actions_index',
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

<?=$this->render('//components/reviews', ['title' => 'Отзывы пациентов', 'title_class' => '', 'reviews' => $reviews, 'link_title' => ''])?>
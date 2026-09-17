<?php

/* @var $this \yii\web\View */
use app\models\forms\RequestReviewForm;
use app\models\SystemSettings;

/* @var $items \app\models\RequestReview[] */
/* @var $pages \app\components\base\Pagination */
/* @var $pages_more \app\components\base\Pagination */
?>

<?=$this->render('//components/_breadcrumbs', ['breadcrumbs' => $this->context->breadcrumbs])?>
<div class="container">
    <h2 class="documents__title heading_h1"><?=$this->context->h1title?></h2>
    <section class="reviews-content">
        <div class="reviews-content__left" id="reviews-block">
            <div class="reviews-list">
                <?php foreach ($items as $review) { ?>
                    <div class="reviews-list__item">
                        <?=$this->render('//review/_item_full', ['review' => $review])?>
                    </div>
                <?php } ?>
            </div>

            <?=$pages_more->draw('//components/pager_more_2', 2, ['pjax_block' => '#reviews-block', 'class' => 'pagination__btn btn btn_secondary'])?>
            <?=$pages->draw('//components/pager', 2, ['pjax_block' => '#reviews-block'])?>
        </div>
        <div class="reviews-content__right">
            <div class="decor-spots">
                <div class="decor-spots__item"></div>
                <div class="decor-spots__item"></div>
                <div class="decor-spots__item"></div>
            </div>
            <div class="reviews-content__info">
                <?=$this->render('_socials', ['class' => ''])?>

                <button class="reviews-content__btn btn btn_primary _open-popup bodytext_n_strong" data-target-id="review_index">Оставьте свой отзыв</button>
            </div>
        </div>
    </section>
</div>

<?php $this->beginBlock('modal-review_index')?>
<?=$this->render('//components/form_modal_common', [
    'modal_id' => 'review_index',
    'pjax_id' => 'review_index',
    'model' => new RequestReviewForm(),
    'template' => 'member_review',
    'title' => 'Оставьте ваш отзыв',
    'button' => 'Оставить отзыв',
    'success_text' => SystemSettings::getParam('form_review' , 'success_text', 'Отзыв отправлен!'),
    'popup_class' => 'popup_review',
])?>
<?php $this->endBlock()?>
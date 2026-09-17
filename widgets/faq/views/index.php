<?php
use app\assets\PjaxAsset;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var string $title
 * @var \app\models\Faq[] $faqs
 * @var \app\components\base\Pagination $pages
 * @var string $pjax_id
 */

PjaxAsset::register($this);
?>

<section class="faq" id="<?=$pjax_id?>">
    <div class="container">
        <div class="decor-spots">
            <div class="decor-spots__item"></div>
            <div class="decor-spots__item"></div>
            <div class="decor-spots__item"></div>
        </div>
        <div class="faq__wrapper">
            <h3 class="faq__title <?=$this->context->title_class?>"><?=$title?></h3>
            <div class="accordion">
                <?php foreach ($faqs as $faq) { ?>
                    <div class="accordion__wrapper _toggle">
                        <div class="accordion__question _toggle__button">
                            <p class="accordion__question__text bodytext_n"><?=$faq->title?></p>
                            <button class="accordion__question__btn">
                                <svg class="icon">
                                    <use xlink:href="#icon-arrow"></use>
                                </svg>
                            </button>
                        </div>
                        <div class="accordion__answer _toggle__container wysiwyg">
                            <?=$faq->text?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?=$pages->draw('//components/pager_more', 2, ['pjax_block' => '#' . $pjax_id, 'class' => 'faq__btn btn btn_secondary'])?>
    </div>
</section>
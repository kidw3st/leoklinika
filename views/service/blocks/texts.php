<?php
/**
 * @var \app\models\Service $service
 * @var \app\models\ServiceBlock $block
 */

$replaces = [
    '<ul>' => '<ul class="service-info__list bodytext_l">',
];

$replaces_modal = [
    '<p>' => '<p class="bodytext_l">',
    '<h5>' => '<h5 class="bodytext_l_strong" style="margin: 32px 0 16px 0;">',
    '<ul>' => '<ul class="bodytext_l" style="margin-bottom: 24px; padding-left: 20px;">',
    '<li>' => '<li style="margin-bottom: 8px;">',
];
?>

<?php if ($block->items_real) { ?>
    <section class="service-info">
        <div class="decor-spots">
            <div class="decor-spots__item"></div>
            <div class="decor-spots__item"></div>
            <div class="decor-spots__item"></div>
        </div>
        <div class="service-info__wrapper">
            <?php foreach ($block->items_real as $item) { ?>
                <div class="service-info__item service-info__item_<?=!empty($item->block_color)?$item->block_color:'about'?> wysiwyg">
                    <?=\app\helpers\base\TextHelper::redactorText($item->text, $replaces)?>
                    <?php if (!empty($item->link) || !empty($item->text_modal)) { ?>
                        <a <?=$item->getLink_attribute('service-info__link', 'text-popup-'.$item->id)?>><?=$item->getLink_title()?>
                            <svg class="icon">
                                <use xlink:href="#icon-arrow"></use>
                            </svg>
                        </a>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </section>

    <?php $this->beginBlock('modal-texts_'.$block->id)?>
        <?php foreach ($block->items_real as $item) { ?>
            <?php if (!empty($item->title_modal)) { ?>
                <div id="text-popup-<?=$item->id?>" class="popup popup_text">
                    <div class="popup__wrapper">
                        <div class="popup__scroll">
                            <div class="popup__close-area"></div>
                            <div class="popup__block">
                                <button class="popup__close">
                                    <svg class="popup__close__icon icon">
                                        <use xlink:href="#icon-close"></use>
                                    </svg>
                                </button>
                                <div class="popup__content">
                                    <div class="popup__content__wrapper">
                                        <div class="popup__content__text">
                                            <?php if (!empty($item->title_modal)) { ?>
                                                <h4 class="popup__content__title"><?=$item->title_modal?></h4>
                                            <?php } ?>
                                            <div class="popup__content__body">
                                                <?=\app\helpers\base\TextHelper::redactorText($item->text_modal, $replaces_modal)?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    <?php $this->endBlock()?>
<?php } ?>
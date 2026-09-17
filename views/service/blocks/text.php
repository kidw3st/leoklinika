<?php
/**
 * @var \app\models\Service $service
 * @var \app\models\ServiceBlock $block
 */

$replaces = [
    '<p>' => '<p class="healthcare-section__text bodytext_l">',
];
?>

<?php if ($block->text) { ?>
    <section class="healthcare-section">
        <div class="container">
            <div class="decor-spots">
                <div class="decor-spots__item"></div>
                <div class="decor-spots__item"></div>
                <div class="decor-spots__item"></div>
            </div>
            <div class="healthcare-section__wrapper">
                <div class="healthcare-section__left">
                    <h2 class="healthcare-section__title"><?=$block->title?></h2>
                </div>
                <div class="healthcare-section__right">
                    <div class="healthcare-section__content">
                        <?=\app\helpers\base\TextHelper::redactorText($block->text, $replaces)?>
                    </div>
                    <?php if (!empty($block->link)) { ?>
                        <a <?=$block->getLink_attribute('healthcare-section__link bodytext_l')?>><?=$block->getLink_title()?>
                            <svg class="healthcare-section__link-icon">
                                <use xlink:href="#icon-arrow"></use>
                            </svg>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
<?php } ?>
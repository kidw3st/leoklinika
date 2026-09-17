<?php
/**
 * @var \app\models\Service $service
 * @var \app\models\ServiceBlock $block
 */

$replaces = [
    '<p>' => '<p class="healthcare-section__paragraph bodytext_l">',
];
?>

<?php if ($block->text) { ?>
    <section class="healthcare-section">
        <div class="container">
            <div class="healthcare-section__wrapper healthcare-section__wrapper--small-gap">
                <div class="healthcare-section__image">
                    <img src="<?=$block->image_obj->getImage()?>" alt="<?=$block->image_alt?>" class="healthcare-section__img">
                </div>
                <div class="healthcare-section__content">
                    <h2 class="healthcare-section__title"><?=$block->title?></h2>
                    <div class="healthcare-section__content">
                        <div class="healthcare-section__text">
                            <?=\app\helpers\base\TextHelper::redactorText($block->text, $replaces)?>
                        </div>
                    </div>
                    <?php if (!empty($block->link)) { ?>
                        <a href="<?=$block->link?>" class="healthcare-section__link bodytext_l"><?=$block->getLink_title()?>
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
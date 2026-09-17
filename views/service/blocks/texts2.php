<?php
/**
 * @var \app\models\Service $service
 * @var \app\models\ServiceBlock $block
 */

$replaces = [
    '<p>' => '<p class="clinic-benefits__info-text bodytext_l">',
];
?>

<?php if ($block->items_real) { ?>
    <section class="clinic-benefits">
        <div class="container">
            <h2 class="clinic-benefits__title"><?=$block->title?></h2>
            <div class="clinic-benefits__grid clinic-benefits__grid--<?=$block->block_class?>">
                <?php foreach ($block->items_real as $item) { ?>
                    <div class="clinic-benefits__item">
                        <div class="clinic-benefits__item__content">
                            <h3 class="clinic-benefits__item__title"><?=$item->title?></h3>
                            <p class="clinic-benefits__item__text"><?=$item->description?></p>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <?php if (!empty($block->text)) { ?>
            <!-- Информационный блок -->
                <div class="clinic-benefits__info">
                    <div class="clinic-benefits__info-icon">
                        <svg class="clinic-benefits__info-icon-svg" xmlns="http://www.w3.org/2000/svg" width="38" height="38" viewBox="0 0 38 38" fill="none">
                            <path d="M18.9855 34.8337C10.243 34.8249 3.16215 27.7322 3.16797 18.9898C3.1738 10.2473 10.2641 3.16408 19.0066 3.16699C27.749 3.16991 34.8346 10.2579 34.8346 19.0003C34.8294 27.7488 27.734 34.8372 18.9855 34.8337ZM6.33464 19.2727C6.40956 26.2413 12.0997 31.8404 19.0687 31.8032C26.0376 31.7655 31.6672 26.1055 31.6672 19.1365C31.6672 12.1675 26.0376 6.50746 19.0687 6.46981C12.0997 6.43254 6.40956 12.0317 6.33464 19.0003V19.2727ZM20.5846 26.917H17.418V23.7503H20.5846V26.917ZM20.5846 20.5837H17.418V11.0837H20.5846V20.5837Z" fill="#AE846F"/>
                        </svg>
                    </div>
                    <div class="clinic-benefits__info-content">
                        <?=\app\helpers\base\TextHelper::redactorText($block->text, $replaces)?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>
<?php } ?>
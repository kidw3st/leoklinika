<?php
/**
 * @var array $pricelist
 */
?>

<div class="accordion">
    <?php if(!empty($pricelist['prices'])) { ?>
        <div class="accordion__wrapper _toggle">
            <div class="accordion__question _toggle__button">
                <p class="accordion__question__text bodytext_n_strong"><?=$pricelist['name']?></p>
                <button class="accordion__question__btn">
                    <svg class="icon">
                        <use xlink:href="#icon-arrow"></use>
                    </svg>
                </button>
            </div>
            <div class="accordion__answer _toggle__container">
                <?=$this->render('_pricelist', ['prices' => $pricelist['prices']])?>
            </div>
        </div>
    <?php } ?>
    <?php if(!empty($pricelist['children'])) { ?>
        <?php foreach($pricelist['children'] as $child) { ?>
            <div class="accordion__wrapper _toggle">
                <div class="accordion__question _toggle__button">
                    <p class="accordion__question__text bodytext_n_strong"><?=$child['name']?></p>
                    <button class="accordion__question__btn">
                        <svg class="icon">
                            <use xlink:href="#icon-arrow"></use>
                        </svg>
                    </button>
                </div>
                <div class="accordion__answer _toggle__container">
                    <?=$this->render('_pricelist_accordion_2', ['pricelist' => $child])?>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
</div>
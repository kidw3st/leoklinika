<?php
use app\models\Page;
use app\models\PageBlock;

/**
 * @var Page $item
 * @var PageBlock $block
 */
?>

<?php if($block->buttons_real) { ?>
    <section class="standarts">
        <div class="container">
            <div class="standarts__container">
                <div class="standarts__left">
                    <h2 class="standarts__title">
                        <span class="accent">Работаем по высоким стандартам</span> и имеем все лицензии и&nbspсертификаты
                    </h2>
                </div>
                <div class="standarts__right">
                    <?php foreach($block->buttons_real as $button) { ?>
                        <a href="<?=$button->link?>" class="btn btn_<?=$button->color?> bodytext_n_strong"><?=$button->title?></a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
<?php } ?>
<?php
use app\helpers\base\TextHelper;
use app\models\Article;
use app\models\Page;
use app\models\PageBlock;

/**
 * @var Page $item
 * @var PageBlock $block
 */
?>

<?php if(!empty($block->articles_real)) {?>
    <section class="articles">
        <div class="container">
            <div class="articles__head">
                <h2 class="articles__title">
                    <?=$block->title?>
                </h2>
                <a href="<?=Article::indexUrl()?>" class="articles__more btn btn_link_arrow bodytext_n_strong _desktop">Смотреть все статьи</a>
            </div>
            <div class="swiper swiper_template">
                <div class="swiper-wrapper">
                    <?php foreach ($block->articles_real as $article) { ?>
                        <div class="swiper-slide">
                            <div class="blog__item">
                                <a class="blog__link" href="<?=$article->selfUrl?>">
                                    <div class="blog__img">
                                        <img src="<?=TextHelper::ImgUrl($article->image_obj->doProp(1920, 2000))?>" alt="<?=TextHelper::Alt($article->title)?>">
                                    </div>
                                    <div class="blog__item__title bodytext_n_strong"><?=$article->title?></div>
                                    <span class="blog__data bodytext_m"><?=$article->date_obj->format('d.m.Y')?></span>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="swiper-navigation _mobile">
                    <div class="swiper-pagination"></div>
                </div>
            </div>
            <a href="<?=Article::indexUrl()?>" class="articles__more btn btn_link_arrow bodytext_n_strong _mobile">Смотреть все статьи</a>

        </div>

    </section>
<?php } ?>
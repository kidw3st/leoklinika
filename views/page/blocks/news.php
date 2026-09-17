<?php
use app\helpers\base\TextHelper;
use app\models\News;
use app\models\Page;
use app\models\PageBlock;

/**
 * @var Page $item
 * @var PageBlock $block
 */
?>

<?php if(!empty($block->news_real)) {?>
    <section class="blog">
        <div class="decor-spots">
            <div class="decor-spots__item"></div>
            <div class="decor-spots__item"></div>
            <div class="decor-spots__item"></div>
        </div>
        <div class="container">
            <h2 class="blog__title megatext_n"><?=$block->title?></h2>
            <div class="blog__inner">
                <div class="blog__left">
                    <div class="blog__list swiper swiper_template">
                        <div class="swiper-pagination"></div>

                        <div class="swiper-wrapper">
                            <?php foreach ($block->news_real as $news) { ?>
                                <div class="swiper-slide">
                                    <div class="blog__item">
                                        <a class="blog__link" href="<?=$news->selfUrl?>">
                                            <div class="blog__img">
                                                <img src="<?=TextHelper::ImgUrl($news->image_obj->doCrop(440, 296))?>" alt="<?=TextHelper::Alt($news->title)?>">
                                            </div>
                                            <div class="blog__item__title bodytext_n_strong"><?=$news->title?></div>
                                            <span class="blog__data bodytext_m"><?=$news->date_obj->format('d.m.Y')?></span>
                                        </a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <a class="blog__more btn btn_link_arrow bodytext_n_strong" href="<?=News::indexUrl()?>"><?=!empty($block->link_title)?$block->link_title:'Смотреть все новости'?></a>
                </div>

                <?php if(!empty($block->articles_real)) {?>
                    <div class="blog__aside">
                        <h5 class="blog__aside__title"><?=$block->title_2?></h5>
                        <ul class="blog__aside__list">
                            <?php foreach ($block->articles_real as $article) { ?>
                                <li class="blog__aside__item">
                                    <a class="blog__aside__item__link" href="<?=$article->selfUrl?>">
                                        <div class="blog__aside__item__title bodytext_n_strong"><?=$article->title?></div>
                                        <div class="blog__aside__item__subtitle bodytext_l"><?=$article->description?></div>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
<?php } ?>
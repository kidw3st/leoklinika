<?php
use app\models\Filial;
use app\models\Page;
use yii\caching\TagDependency;

/**
 * @var Page $item
 */
?>

<?php if ($item->show_header) { ?>
    <?=$this->render('//components/_breadcrumbs', ['breadcrumbs' => $this->context->breadcrumbs])?>
    <div class="container">
        <h1 class="cabout__page__title"><?=$this->context->h1title?></h1>
    </div>
<?php } ?>

<?php if ($item->blocks_real) { ?>
    <?php foreach ($item->blocks_real as $block) { ?>
        <?php
            $cacheKey = ['page_blocks', $block->id, Filial::getCurrent()->id];
            if (($block_render = Yii::$app->cache->get($cacheKey)) === false) {
                $template = 'blocks/'.$block->block_type;
                if (file_exists(Yii::getAlias('@app/views/page/').$template.'_' . $item->template . '.php')) {
                    $template .= '_' . $item->template;
                }
                $block_render = $this->render($template, ['item' => $item, 'block' => $block]);

                if (in_array($block->block_type, ['actions', 'advantages', 'banner', 'map', 'news', 'reviews', 'slider', 'text', 'text_image', 'text_seo'])) Yii::$app->cache->set($cacheKey, $block_render, 86400, new TagDependency(['tags' => 'page_blocks']));
            }
        ?>
        <?=$block_render?>
    <?php } ?>
<?php } ?>
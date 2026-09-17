<?php
use app\helpers\base\TextHelper;
use app\models\Page;
use app\models\PageBlock;

/**
 * @var Page $item
 * @var PageBlock $block
 */
?>

<section class="documents__wrapper">
    <div class="container wysiwyg">
        <?=TextHelper::redactorText($block->text)?>
    </div>
</section>
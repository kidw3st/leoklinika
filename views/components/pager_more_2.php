<?php if ($maxPage > 1 && $currentPage < $maxPage) { ?>
    <div class="pagination-more">
        <a data-pjax-block="<?=$options['pjax_block']?>" href="<?=$pages->getUrl($currentPage+1)?>" class="<?=$options['class']?>">Показать еще</a>
    </div>
<?php } ?>
<?php if ($maxPage > 1 && $currentPage < $maxPage) { ?>
    <a data-pjax-block="<?=$options['pjax_block']?>" href="<?=$pages->getUrl($currentPage+1)?>" class="<?=$options['class']?>">Показать еще</a>
<?php } ?>
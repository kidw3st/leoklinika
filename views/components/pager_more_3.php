<?php if ($maxPage > 1 && $currentPage < $maxPage) { ?>
    <div class="<?=$options['class']?>">
        <a data-pjax-block="<?=$options['pjax_block']?>" href="<?=$pages->getUrl($currentPage+1)?>" class="btn btn_secondary">Показать еще</a>
    </div>
<?php } ?>
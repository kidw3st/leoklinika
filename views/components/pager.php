<?php
use app\helpers\base\TextHelper;
?>

<?php if (false) { ?>
    <div class="pagination">
        <p class="text">Вы просмотрели <?=$showedCnt?> из <?=$pages->totalCount?> <?=TextHelper::getNumEnding($pages->totalCount, ['кейса', 'кейсов', 'кейсов'])?></p>
        <div class="pagination-buttons">
            <div class="pages-wrapper">
                <div class="process"></div>
                <div class="pages">
                    <?php for ($i = $startPage; $i <= $endPage; $i++) { ?>
                        <a class="btn btn-page<?=($i==$currentPage)?' active':''?>" href="<?=$pages->getUrl($i)?>"><?=$i?></a>
                    <?php } ?>
                </div>
            </div>
            <?php if($currentPage < $maxPage) { ?>
                <a class="btn btn-forward" href="<?=$pages->getUrl($currentPage+1)?>">Вперёд</a>
            <?php } ?>
        </div>
    </div>

    <a class="pagination__page btn btn_secondary bodytext_m _active" href="#">1</a>
    <a class="pagination__page btn btn_secondary bodytext_m" href="#">2</a>
    <p class="pagination__page btn btn_secondary bodytext_m _inactive">...</p>
    <a class="pagination__page btn btn_secondary bodytext_m" href="#">24</a>
    <a class="pagination__page btn btn_secondary bodytext_m" href="#">25</a>
<?php } ?>

<?php if ($maxPage > 1) { ?>
    <div class="pagination">
        <?php if($currentPage > 1) { ?>
            <a href="<?=$pages->getUrl($currentPage-1)?>" data-pjax-block="<?=$options['pjax_block']?>" class="pagination__btn btn btn_secondary">
                <svg class="icon">
                    <use xlink:href="#icon-arrow-left"></use>
                </svg>
            </a>
        <?php } ?>

        <div class="pagination__container">
            <?php for ($i = $startPage; $i <= $endPage; $i++) { ?>
                <a data-pjax-block="<?=$options['pjax_block']?>" class="pagination__page btn btn_secondary bodytext_m <?=($i==$currentPage)?' _active':''?>" href="<?=$pages->getUrl($i)?>"><?=$i?></a>
            <?php } ?>
        </div>

        <?php if ($currentPage < $maxPage) { ?>
            <a href="<?=$pages->getUrl($currentPage+1)?>" data-pjax-block="<?=$options['pjax_block']?>" class="pagination__btn btn btn_secondary">
                <svg class="icon">
                    <use xlink:href="#icon-arrow-right"></use>
                </svg>
            </a>
        <?php } ?>
    </div>
<?php } ?>
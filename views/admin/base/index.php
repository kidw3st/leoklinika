<?php
use yii\grid\GridView;
?>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?=$title?></h3>
                    <div class="btn-group pull-right">
                        <?php if(isset($formLinks)) { ?>
                            <?php foreach($formLinks as $formLink) { ?>
                                <?php if (empty($formLink['children'])) { ?>
                                    <a class="btn btn-<?=$formLink['type']?>" href="<?=$formLink['url']?>"><?=$formLink['label']?></a>
                                <?php } else { ?>
                                    <button type="button" class="btn btn-<?=$formLink['type']?> dropdown-toggle" data-toggle="dropdown"><?=$formLink['label']?></button>
                                    <ul class="dropdown-menu" role="menu">
                                        <?php foreach($formLink['children'] as $link) { ?>
                                            <li><a href="<?=$link['url']?>"><?=$link['label']?></a></li>
                                        <?php } ?>
                                    </ul>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
                <div class="box-body" style="overflow-x: auto;">
                    <?php if($tabs) { ?>
                        <ul class="nav nav-tabs">
                            <?php foreach($tabs as $tab) { ?>
                                <li class="<?=$tab['active']?'active':''?>"><a href="<?=$tab['url']?>"><?=$tab['label']?></a></li>
                            <?php } ?>
                        </ul>
                        <br/>
                    <?php } ?>
                    <?=GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => array_merge($columns),
                    ]);?>
                </div>
                <?php /*
                <div class="box-footer">
                    <div class="col-sm-3">
                        <div class="pageSizer">
                            Выводить по
                            <a class="<?=($dataProvider->pagination->pageSize==10)?'active':''?>" href="<?=SystemHelper::getUrl(['ps' => 10], ['page'])?>">10</a>
                            <a class="<?=($dataProvider->pagination->pageSize==20)?'active':''?>" href="<?=SystemHelper::getUrl(['ps' => 20], ['page'])?>">20</a>
                            <a class="<?=($dataProvider->pagination->pageSize==50)?'active':''?>" href="<?=SystemHelper::getUrl(['ps' => 50], ['page'])?>">50</a>
                            <a class="<?=($dataProvider->pagination->pageSize==100)?'active':''?>" href="<?=SystemHelper::getUrl(['ps' => 100], ['page'])?>">100</a>
                        </div>
                    </div>
                </div>*/ ?>
            </div>
        </div>
    </div>
</section>

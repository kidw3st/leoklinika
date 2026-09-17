<?php
use app\assets\base\Js_treeAsset;
use app\helpers\base\TextHelper;
use yii\helpers\Url;

Js_treeAsset::register($this);
?>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Модель</h3>
                    <div class="btn-group pull-right">
                        <?php foreach($formLinks as $formLink) { ?>
                            <?php if (count($formLink['children']) == 0) { ?>
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
                    </div>
                </div>
                <div class="box-body" style="overflow-x: auto;">
                    <div id="jstree">
                        <?php TextHelper::drawTreeRaw($items, 'title',
                            function($item) {
                                return 'data-url="' . Url::toRoute(['/' . $this->context->uniqueId.'/form', 'id' => $item->id, 'back' => Yii::$app->request->url]) . '" data-title="' . $item->title . '" data-id="' . $item->id . '"';
                            }
                        ) ?>
                    </div>
                </div>
                <div class="box-footer">
                </div>
            </div>
        </div>
    </div>
</section>

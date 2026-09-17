<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?=$title?></h3>
                    <?php if(!empty($backUrl)) { ?>
                        <div class="btn-group pull-right">
                            <a href="<?=$backUrl?>" class="btn btn-default"><?=$backLabel?></a>
                        </div>
                    <?php } ?>
                </div>
                <form role="form" method="post" enctype="multipart/form-data">
                    <div class="box-body" style="overflow-x: auto;">
                        <?php if(!empty($tabs)) { ?>
                            <ul class="nav nav-tabs">
                                <?php foreach($tabs as $tab) { ?>
                                    <li class="<?=$tab['active']?'active':''?>"><a href="<?=$tab['url']?>"><?=$tab['label']?></a></li>
                                <?php } ?>
                            </ul>
                            <br/>
                        <?php } ?>

                        <?php foreach($options['fields'] as $attribute => $field) { ?>
                            <?php if ($model->isNewRecord && !empty($options['fields'][$attribute]['inserted']) || !$model->isNewRecord && !empty($options['fields'][$attribute]['edited'])) { ?>
                                <?=$this->render(($options['fields'][$attribute]['viewFile']?:('form/'.$options['fields'][$attribute]['type'])), ['model' => $model, 'field' => $field, 'attribute' => $attribute, 'options' => $options])?>
                            <?php } ?>
                        <?php } ?>
                        <?php if($model->isNewRecord && $options['tree']) { ?>
                            <?=$this->render('form/tree_parent', ['model' => $model])?>
                        <?php } ?>
                    </div>

                    <div class="box-footer">
                        <div class="btn-group pull-right">
                            <?php if($backUrl) { ?>
                                <button type="submit" name="submit" value="cancel" class="btn btn-default">Отмена</button>
                            <?php } ?>
                            <button type="submit" name="submit" value="apply" class="btn btn-info">Принять</button>
                            <?php if($backUrl) { ?>
                                <button type="submit" name="submit" value="save" class="btn btn-success">Сохранить</button>
                            <?php } ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
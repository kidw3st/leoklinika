<div class="form-group<?=$model->hasErrors($attribute)?' has-error':''?>">
    <label for="<?=$attribute?>"><?=$model->getAttributeLabel($attribute)?></label>
    <div class="row">
        <div class="col-xs-2">
            <input id="<?=$attribute?>" type="time" name="<?=$model->formNameWithVar($attribute.'_from')?>" class="form-control" value="<?=$model->{$attribute.'_from'}?>"/>
        </div>
        <div class="col-xs-2">
            <input id="<?=$attribute?>" type="time" name="<?=$model->formNameWithVar($attribute.'_to')?>" class="form-control" value="<?=$model->{$attribute.'_to'}?>"/>
        </div>
    </div>

    <?php if($model->hasErrors($attribute)) { ?>
        <span class="help-block"><?=$model->getFirstError($attribute)?></span>
    <?php } ?>
</div>
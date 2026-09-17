<div class="form-group<?=$model->hasErrors($attribute)?' has-error':''?>">
    <label for="<?=$attribute?>"><?=$model->getAttributeLabel($attribute)?></label>
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
        <input id="<?=$attribute?>" name="<?=$model->formNameWithVar($attribute)?>" type="email" class="form-control" placeholder="<?=$model->getAttributeHint($attribute)?>" value="<?=$model->{$attribute}?>">
    </div>
    <?php if($model->hasErrors($attribute)) { ?>
        <span class="help-block"><?=$model->getFirstError($attribute)?></span>
    <?php } ?>
</div>
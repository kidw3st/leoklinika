<div class="form-group<?=$model->hasErrors($attribute)?' has-error':''?>">
    <label for="<?=$attribute?>"><?=$model->getAttributeLabel($attribute)?></label>
    <input id="<?=$attribute?>" name="<?=$model->formNameWithVar($attribute.'_input')?>" type="password" class="form-control" placeholder="<?=$model->getAttributeHint($attribute)?>" value="<?=$model->{$attribute.'_input'}?>">

    <?php if($model->hasErrors($attribute)) { ?>
        <span class="help-block"><?=$model->getFirstError($attribute)?></span>
    <?php } ?>
</div>
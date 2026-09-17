<div class="form-group<?=$model->hasErrors($attribute)?' has-error':''?>">
    <label>
        <input name="<?=$model->formNameWithVar($attribute)?>" type="hidden" value="0" />
        <input name="<?=$model->formNameWithVar($attribute)?>" type="checkbox" class="minimal" value="1"<?=$model->{$attribute}?' checked':''?> />
        <?=$model->getAttributeLabel($attribute)?>
    </label>
    <?php if($model->hasErrors($attribute)) { ?>
        <span class="help-block"><?=$model->getFirstError($attribute)?></span>
    <?php } ?>
</div>
<div class="form-group<?=$model->hasErrors($attribute)?' has-error':''?>">
    <label for="<?=$attribute?>"><?=$model->getAttributeLabel($attribute)?></label>
    <div class="input-group">
        <input id="<?=$attribute?>" name="<?=$model->formNameWithVar($attribute)?><?=empty($multiple)?'':'[]'?>" type="file"<?=empty($multiple)?'':' multiple'?>/>
    </div>
    <?php if($model->hasErrors($attribute)) { ?>
        <span class="help-block"><?=$model->getFirstError($attribute)?></span>
    <?php } ?>
</div>
<?php
use mihaildev\ckeditor\CKEditor;
?>

<div class="form-group<?=$model->hasErrors($attribute)?' has-error':''?>">
    <label for="<?=$attribute?>"><?=$model->getAttributeLabel($attribute)?></label>
    <textarea id="<?=$attribute?>" name="<?=$model->formNameWithVar($attribute)?>" class="form-control" rows="3" placeholder="<?=$model->getAttributeHint($attribute)?>"><?=$model->{$attribute}?></textarea>

    <?php if($model->hasErrors($attribute)) { ?>
        <span class="help-block"><?=$model->getFirstError($attribute)?></span>
    <?php } ?>
</div>
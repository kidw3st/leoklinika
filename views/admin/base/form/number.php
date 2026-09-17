<?php
use mihaildev\ckeditor\CKEditor;
?>

<div class="form-group<?=$model->hasErrors($attribute)?' has-error':''?>">
    <label for="<?=$attribute?>"><?=$model->getAttributeLabel($attribute)?></label>
    <input type="text" id="<?=$attribute?>" name="<?=$model->formNameWithVar($attribute)?>" class="form-control" placeholder="<?=$model->getAttributeHint($attribute)?>" value="<?=$model->{$attribute}?>"/>

    <?php if($model->hasErrors($attribute)) { ?>
        <span class="help-block"><?=$model->getFirstError($attribute)?></span>
    <?php } ?>
</div>
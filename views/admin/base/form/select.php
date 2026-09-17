<?php
use app\assets\base\Select2Asset;

$items = $field['items'];

Select2Asset::register($this);
?>

<div class="form-group<?=$model->hasErrors($attribute)?' has-error':''?>">
    <label for="<?=$attribute?>"><?=$model->getAttributeLabel($attribute)?></label>
    <select class="form-control select2" name="<?=$model->formNameWithVar($attribute)?>" style="width: 100%;">
        <option value="">Не выбрано</option>
        <?php foreach($items as $id => $value) { ?>
            <option value="<?=$id?>"<?=$model->{$attribute}==$id?' selected':''?>><?=$value?></option>
        <?php } ?>
    </select>

    <?php if($model->hasErrors($attribute)) { ?>
        <span class="help-block"><?=$model->getFirstError($attribute)?></span>
    <?php } ?>
</div>
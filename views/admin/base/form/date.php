<?php
use app\assets\base\DatepickerAsset;

$input_var = $attribute . '_input';

DatepickerAsset::register($this);
?>

<div class="form-group<?=$model->hasErrors($attribute)?' has-error':''?>">
    <label for="<?=$attribute?>"><?=$model->getAttributeLabel($attribute)?></label>
    <div class="input-group date">
        <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
        </div>
        <input name="<?=$model->formNameWithVar($input_var)?>" placeholder="<?=$model->getAttributeHint($attribute)?>" type="text" class="form-control pull-right datepicker" value="<?=$model->{$input_var}?>" autocomplete="off">
    </div>
    <?php if($model->hasErrors($attribute)) { ?>
        <span class="help-block"><?=$model->getFirstError($attribute)?></span>
    <?php } ?>
</div>
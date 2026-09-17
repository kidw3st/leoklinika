<?php
/**
 * @var \app\components\base\CActiveRecord $model
 * @var string $attribute
 */
$option_attributes = (empty($option_attributes)?'':(' '.$option_attributes));
?>
<label class="form__label form__label_file">
    <?=$model->getAttributeLabel($attribute)?>
    <input class="form__input form__input_file" size="40" name="<?=$model->formNameWithVar($attribute)?>" type="file">
</label>
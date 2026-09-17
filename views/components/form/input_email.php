<?php
/**
 * @var \app\components\base\CActiveRecord $model
 * @var string $attribute
 */

// pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
$option_attributes = (empty($option_attributes)?'':(' '.$option_attributes));
?>

<label class="form__label form__label_<?=$attribute?><?=$model->hasErrors($attribute)?' _error':''?><?=(!empty($model->$attribute) && !$model->hasErrors($attribute))?' _success':''?>">
    <input class="form__input bodytext_m mail-mask" size="20" name="<?=$model->formNameWithVar($attribute)?>" type="email" placeholder="<?=$model->getAttributeHint($attribute)?>" value="<?=$model->$attribute?>"<?=$option_attributes?>>
</label>
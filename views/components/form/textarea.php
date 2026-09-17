<?php
/**
 * @var \app\components\base\CActiveRecord $model
 * @var string $attribute
 */

// pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
$option_attributes = (empty($option_attributes)?'':(' '.$option_attributes));
?>

<label class="form__label form__label_<?=$attribute?><?=$model->hasErrors($attribute)?' _error':''?><?=(!empty($model->$attribute) && !$model->hasErrors($attribute))?' _success':''?>">
    <textarea class="form__input form__textarea" name="<?=$model->formNameWithVar($attribute)?>" cols="30" rows="10"  placeholder="<?=$model->getAttributeHint($attribute)?>" <?=$option_attributes?>><?=$model->$attribute?></textarea>
</label>
<?php
/**
 * @var \app\components\base\CActiveRecord $model
 * @var string $attribute
 */

// pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
$option_attributes = (empty($option_attributes)?'':(' '.$option_attributes));
$value = '';
if (!empty($model->$attribute)) $value = date('Y-m-d', strtotime($model->$attribute));
?>

<label class="form__label form__label_<?=$attribute?><?=$model->hasErrors($attribute)?' _error':''?><?=(!empty($model->$attribute) && !$model->hasErrors($attribute))?' _success':''?>">
    <span class="form__label__name bodytext_m"><?=$model->getAttributeLabel($attribute)?><?=$model->isAttributeRequired($attribute)?' *':''?></span>
    <input class="form__input bodytext_m" size="20" name="<?=$model->formNameWithVar($attribute)?>" type="date" placeholder="<?=$model->getAttributeHint($attribute)?>" value="<?=$value?>"<?=$option_attributes?>>
</label>
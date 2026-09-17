<?php
/**
 * @var \app\components\base\CActiveRecord $model
 * @var string $attribute
 */

// pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
$option_attributes = (empty($option_attributes)?'':(' '.$option_attributes));
?>

<span class="form__label__name bodytext_m"><?=$model->getAttributeLabel($attribute)?>:</span>
<fieldset class="radio">
    <?php foreach ($items as $k => $v) { ?>
        <label>
            <input class="radio__real" type="radio" name="delivery_method" value="<?=$k?>"<?=($k==$model->$attribute)?' checked':''?>>
            <span class="radio__custom"></span>
            <span class="radio__text bodytext_m"><?=$v?></span>
        </label>
    <?php } ?>
</fieldset>
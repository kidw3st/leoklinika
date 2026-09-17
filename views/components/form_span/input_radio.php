<?php
/**
 * @var \app\components\base\CActiveRecord $model
 * @var string $attribute
 */

// pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
$option_attributes = (empty($option_attributes)?'':(' '.$option_attributes));
?>

<div class="form__block">
    <fieldset class="radio">
        <?php foreach ($items as $k => $v) { ?>
            <label class="_active">
                <input class="radio__real" type="radio" name="<?=$model->formNameWithVar($attribute)?>" id="true" value="<?=$k?>"<?=($k==$model->$attribute)?' checked':''?>>
                <span class="radio__custom"></span>
                <span class="radio__text bodytext_m"><?=$v?></span>
            </label>
        <?php } ?>
    </fieldset>
</div>
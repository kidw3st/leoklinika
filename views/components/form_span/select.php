<?php
/**
 * @var \app\components\base\CActiveRecord $model
 * @var string $attribute
 * @var array $items
 */
$option_attributes = (empty($option_attributes)?'':(' '.$option_attributes));
?>

<label class="form__label bodytext_l form__label_<?=$class?$class:$attribute?><?=$model->hasErrors($attribute)?' _error':''?><?=(!empty($model->$attribute) && !$model->hasErrors($attribute))?' _success':''?>">
    <span class="form__label__name"><?=$model->getAttributeLabel($attribute)?></span>
    <select class="form__input" name="<?=$model->formNameWithVar($attribute)?>"<?=$option_attributes?>>
        <?php foreach ($items as $k => $item) { ?>
            <option value="<?=$k?>"><?=$item?></option>
        <?php } ?>
    </select>
    <?php if (!empty($model->$attribute) && !$model->hasErrors($attribute)) { ?>
        <span class="form__label__result form__label__result_success">Успешно</span>
    <?php } ?>
    <?php if ($model->hasErrors($attribute)) { ?>
        <span class="form__label__result form__label__result_error">Не успешно</span>
    <?php } ?>
</label>
<?php $model->clearErrors($attribute); ?>
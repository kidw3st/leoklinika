<?php
use app\assets\base\Select2Asset;
use yii\helpers\ArrayHelper;

Select2Asset::register($this);

$list = [];
if ($field['criteria']) {
    $criteria = $field['criteria'];
} else {
    $cn = $field['class'];
    $criteria = $cn::find();
}
$list = ArrayHelper::map($criteria->all(), 'id', $field['list_template']);
?>

<div class="form-group<?=$model->hasErrors($attribute)?' has-error':''?>">
    <label for="<?=$attribute?>"><?=$model->getAttributeLabel($attribute)?></label>
    <select class="form-control select2" name="<?=$model->formNameWithVar($attribute)?>" style="width: 100%;">
        <option value="">Не выбрано</option>
        <?php foreach($list as $id => $value) { ?>
            <option value="<?=$id?>"<?=$model->{$attribute}==$id?' selected':''?>><?=$value?></option>
        <?php } ?>
    </select>

    <?php if($model->hasErrors($attribute)) { ?>
        <span class="help-block"><?=$model->getFirstError($attribute)?></span>
    <?php } ?>
</div>
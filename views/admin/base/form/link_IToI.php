<?php
use app\assets\base\Select2Asset;
use yii\helpers\ArrayHelper;

Select2Asset::register($this);

$is_ajax = !empty($field['link_ajax']) && $field['link_ajax'];

if (!$is_ajax) {
    if ($fieldOptions && $fieldOptions['criteria']) {
        $list = ArrayHelper::map($fieldOptions['criteria']->all(), 'id', $field['list_template']);
    } else {
        $cn = $field['linkiiParent'];
        $list = ArrayHelper::map($cn::find()->all(), 'id', $field['list_template']);
    }
}
?>

<div class="form-group<?=$model->hasErrors($attribute)?' has-error':''?>">
    <label for="<?=$attribute?>"><?=$model->getAttributeLabel($attribute)?></label>
    <input type="hidden" name="<?=$model->formNameWithVar($attribute.'_input')?>" value="empty" />
    <select class="form-control <?=$is_ajax?'select2-ajax':'select2'?>" data-classname="<?=get_class($model)?>" data-target-field="<?=$attribute?>" name="<?=$model->formNameWithVar($attribute.'_input')?>[]" style="width: 100%;" multiple>
        <?php if (!$is_ajax) { ?>
            <?php foreach($list as $id => $value) { ?>
                <option value="<?=$id?>"<?=is_array($model->{$attribute.'_input'}) && in_array($id, $model->{$attribute.'_input'})?' selected':''?>><?=$value?></option>
            <?php } ?>
        <?php } else { ?>
            <?php foreach($model->$attribute as $value) { ?>
                <option value="<?=$value->id?>" selected><?=$value->{$field['list_template']}?></option>
            <?php } ?>
        <?php } ?>
    </select>

    <?php if($model->hasErrors($attribute)) { ?>
        <span class="help-block"><?=$model->getFirstError($attribute)?></span>
    <?php } ?>
</div>
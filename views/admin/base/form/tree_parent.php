<?php
$className = get_class($model);
?>

<div class="form-group<?=$model->hasErrors('tree_parent_id')?' has-error':''?>">
    <label for="tree_parent_id"><?=$model->getAttributeLabel('tree_parent_id')?></label>
    <select id="tree_parent_id" name="<?=$model->formNameWithVar('tree_parent_id')?>" class="form-control">
        <?php foreach($className::find()->getDropDownList() as $k => $value) { ?>
            <option value="<?=$k?>"<?=$model->tree_parent_id==$k?' selected':''?>><?=$value?></option>
        <?php } ?>
    </select>
    <?php if($model->hasErrors('tree_parent_id')) { ?>
        <span class="help-block"><?=$model->getFirstError('tree_parent_id')?></span>
    <?php } ?>
</div>
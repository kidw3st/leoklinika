<?php
    $varObj = $attribute . '_obj';
?>

<div class="form-group<?=$model->hasErrors($attribute)?' has-error':''?>">
    <label for="<?=$attribute?>"><?=$model->getAttributeLabel($attribute)?></label>
    <div class="input-group">
        <input id="<?=$attribute?>" name="<?=$model->formNameWithVar($attribute.'_input')?>" type="file"/>
    </div>
    <?php if($model->hasErrors($attribute.'_input')) { ?>
        <span class="help-block"><?=$model->getFirstError($attribute.'_input')?></span>
    <?php } ?>

    <?php if ($model->$attribute != '') { ?>
        <?php if($field['isImage']) { ?>
            <img class="img-responsive pad" src="<?=\app\helpers\base\TextHelper::ImgUrl($model->$varObj->doProp(200, 200))?>" alt="Photo" style="max-width: 200px; max-height: 200px; background: #ccc" />
        <?php } else { ?>
            <a href="<?=$model->$attribute?>" target="_blank"><?=$model->$attribute?></a>
        <?php } ?>
        <div class="input-group">
            <label><input name="<?=$model->formNameWithVar($attribute.'_del')?>" value="1" type="checkbox"/> Удалить</label>
        </div>
    <?php } ?>
</div>
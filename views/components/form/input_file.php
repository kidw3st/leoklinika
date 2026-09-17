<?php
/**
 * @var \app\components\base\CActiveRecord $model
 * @var string $attribute
 */
$option_attributes = (empty($option_attributes)?'':(' '.$option_attributes));
?>
<label class="form__label form__label_file">
    <input type="file" name="<?=$model->formNameWithVar($attribute)?>" class="form__input form__input_file" accept=".pdf, .doc, .docx, .rtf, .txt, .jpg, .jpeg, .png, .gif, .bmp, .tiff, .tif, .webp">
    <div class="file-wrapper">
        <div class="caption caption-icon--inner bodytext_m">
            <svg class="icon">
                <use xlink:href="#icon-download"></use>
            </svg>
            <span><?=$model->getAttributeHint($attribute)?></span>
        </div>
        <span class="caption bodytext_m">Общий вес не более 10Мб</span>
    </div>
</label>
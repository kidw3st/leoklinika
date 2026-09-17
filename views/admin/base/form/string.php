<?php
use mihaildev\ckeditor\CKEditor;
?>

<?php if($field['editor'] == 'input') { ?>
    <?=$this->render('string_input', ['model' => $model, 'field' => $field, 'attribute' => $attribute, 'options' => $options])?>
<?php } elseif($field['editor'] == 'textarea') { ?>
    <?=$this->render('string_textarea', ['model' => $model, 'field' => $field, 'attribute' => $attribute, 'options' => $options])?>
<?php } elseif($field['editor'] == 'times') { ?>
    <?=$this->render('string_times', ['model' => $model, 'field' => $field, 'attribute' => $attribute, 'options' => $options])?>
<?php } else { ?>
    <?=$this->render('string_redactor', ['model' => $model, 'field' => $field, 'attribute' => $attribute, 'options' => $options])?>
<?php } ?>
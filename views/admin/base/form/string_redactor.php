<?php
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

$styles =   [
    ['name' => 'Italic Title', 'element' => 'h2', 'styles' => [ 'font-style' => 'italic' ]],
    ['name' => 'Subtitle', 'element' => 'h3', 'styles' => [ 'color' => '#aaa', 'font-style' => 'italic' ]],
    ['name' => 'Special Container', 'element' => 'div', 'styles' => [ 'padding' => '5px 10px', 'background' => '#eee', 'border' => '1px solid #ccc']],
    ['name' => 'Marker',			'element' => 'span', 'attributes' => [ 'class' => 'marker' ] ],
    ['name' => 'Big',				'element' => 'big' ],
    ['name' => 'Small',			'element' => 'small' ],
    ['name' => 'Typewriter',		'element' => 'tt' ],
    ['name' => 'Computer Code',	'element' => 'code' ],
    ['name' => 'Keyboard Phrase',	'element' => 'kbd' ],
    ['name' => 'Sample Text',		'element' => 'samp' ],
    ['name' => 'Variable',			'element' => 'var' ],
    ['name' => 'Deleted Text',		'element' => 'del' ],
    ['name' => 'Inserted Text',	'element' => 'ins' ],
    ['name' => 'Cited Work',		'element' => 'cite' ],
    ['name' => 'Inline Quotation',	'element' => 'q' ],
    ['name' => 'Language: RTL',	'element' => 'span', 'attributes' => [ 'dir' => 'rtl' ] ],
    ['name' => 'Language: LTR',	'element' => 'span', 'attributes' => [ 'dir' => 'ltr' ] ],
    ['name' => 'Styled image (left)', 'element' => 'img', 'attributes' => [ 'class' => 'left' ]],
    ['name' => 'Styled image (right)', 'element' => 'img', 'attributes' => [ 'class' => 'right' ]],
    ['name' => 'Compact table', 'element' => 'table', 'attributes' => ['cellpadding' => '5', 'cellspacing' => '0', 'border' => '1', 'bordercolor' => '#ccc'], 'styles' => ['border-collapse' => 'collapse']],
    ['name' => 'Borderless Table',		'element' => 'table',	'styles' => [ 'border-style' => 'hidden', 'background-color' => '#E6E6FA' ] ],
    ['name' => 'Square Bulleted List',	'element' => 'ul',		'styles' => [ 'list-style-type' => 'square' ] ],
];

/*$styles[] = ['name' => 'Выделенный текст', 'element' => 'p', 'attributes' => [ 'class' => 'lead' ]];
$styles[] = ['name' => 'Выделенный текст слева', 'element' => 'p', 'attributes' => [ 'class' => 'lead text-left' ]];
$styles[] = ['name' => 'Текст слева', 'element' => 'p', 'attributes' => [ 'class' => 'text-left' ]];
$styles[] = ['name' => 'Заголовок по центру', 'element' => 'h1', 'attributes' => [ 'class' => 'text-center' ]];
$styles[] = ['name' => 'Файл', 'element' => 'a', 'attributes' => [ 'class' => 'download-file' ]];*/

$styles = array_merge($styles, Yii::$app->params['admin']['redactor_styles']);
?>

<div class="form-group<?=$model->hasErrors($attribute)?' has-error':''?>">
    <label for="<?=$attribute?>"><?=$model->getAttributeLabel($attribute)?></label>
    <?=CKEditor::widget([
            'editorOptions' => ElFinder::ckeditorOptions('elfinder', [
                //'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                'inline' => false, //по умолчанию false
                //'filebrowserBrowseUrl' => '/elfinder/manager',
                //'filebrowserImageBrowseUrl' => '/elfinder/manager?filter=image',
                //'filebrowserFlashBrowseUrl' => '/elfinder/manager?filter=flash',
                'stylesSet' => $styles,
                'toolbarGroups' => [
                    ['name' => 'clipboard', 'groups' => ['mode','undo', 'selection', 'clipboard', 'doctools']],
                    ['name' => 'editing', 'groups' => ['find', 'spellchecker', 'tools', 'about']],
                    '/',
                    ['name' => 'styles'],
                    ['name' => 'blocks'],
                    ['name' => 'paragraph', 'groups' => ['templates', 'list', 'indent', 'align']],
                    '/',
                    ['name' => 'basicstyles', 'groups' => ['basicstyles', 'colors','cleanup']],
                    ['name' => 'links', 'groups' => ['links', 'insert']],
                    ['name' => 'widget'],
                    ['name' => 'others'],
                ],
                'extraAllowedContent' => 'dl dt dd span[data-hint] span[data-hint-title]',
            ]),
            'name' => $model->formNameWithVar($attribute),
            'value' => $model->{$attribute},
        ]); ?>

    <?php if($model->hasErrors($attribute)) { ?>
        <span class="help-block"><?=$model->getFirstError($attribute)?></span>
    <?php } ?>
</div>
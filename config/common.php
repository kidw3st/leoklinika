<?php

$config['components']['mailer'] = [
    'class' => 'app\components\base\Mailer',
    'useFileTransport' => false,
];

$config['components']['realmailer'] = [
    'class' => 'yii\swiftmailer\Mailer',
    'useFileTransport' => false,
];

$config['components']['image'] = [
    'class' => 'yii\image\ImageDriver',
    'driver' => 'GD',  //GD or Imagick
];

$config['components']['queue'] = [
    'class' => \yii\queue\file\Queue::class,
    'as log' => \yii\queue\LogBehavior::class,
];
$config['name'] = 'Project';
$config['params']['admin'] = [
    'title' => 'Project',
    'short_title' => 'Prjct',
    'redactor_styles' => [
        ['name' => 'Акцент', 'element' => 'p', 'attributes' => [ 'class' => 'accent bodytext_n_strong' ]],
        ['name' => 'bodytext_l', 'element' => 'p', 'attributes' => [ 'class' => 'bodytext_l' ]],
        ['name' => 'documents__text_bodytext_l', 'element' => 'p', 'attributes' => [ 'class' => 'documents__text bodytext_l' ]],
        ['name' => 'documents__text_h5', 'element' => 'h2', 'attributes' => [ 'class' => 'documents__text h5' ]],
        ['name' => 'bodytext_n_strong_color', 'element' => 'p', 'attributes' => [ 'class' => 'bodytext_n_strong color' ]],
        ['name' => 'megatext_s_strong', 'element' => 'p', 'attributes' => [ 'class' => 'megatext_s_strong' ]],
        ['name' => 'Модалка обратной связи', 'element' => 'a', 'attributes' => [ 'class' => '_open-popup', 'data-target-id' => 'layout_appointment' ]],
        ['name' => 'Ссылка на pdf', 'element' => 'a', 'attributes' => [ 'class' => 'document document_pdf' ]],
    ],
    'debug' => false,
];

$config['bootstrap'][] = 'queue';

return $config;
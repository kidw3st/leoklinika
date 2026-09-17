<?php
use mihaildev\elfinder\InputFile;
use mihaildev\elfinder\ElFinder;
use yii\web\JsExpression;
?>

<div class="elfinder-container">
    <?php
        echo ElFinder::widget([
            'language'         => 'ru',
            'controller'       => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
            'containerOptions' => ['style'=>'height: 800px;'],
            'filter'           => [
                "image",
                "application/pdf",
                "application/zip",
                "application/gzip",
                "application/vnd.ms-excel",
                "application/msword",
                "application/vnd.ms-powerpoint",
            ],
            'callbackFunction' => new JsExpression('function(file, id){}') // id - id виджета
        ]);
    ?>
</div>

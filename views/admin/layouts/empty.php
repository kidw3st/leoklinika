<?php
use yii\helpers\Html;

yidas\adminlte\AdminlteAsset::register($this);
?>
<?php $this->beginPage() ?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?= Html::encode($this->title) ?></title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?php $this->head() ?>
    </head>
    <body class="hold-transition login-page">
        <?php $this->beginBody() ?>
            <?=$content?>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
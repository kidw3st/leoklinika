<?php
use app\components\recaptcha\Recaptcha;
use app\models\forms\RequestFeedbackForm;
use app\widgets\form\FormWidget;
use yii\helpers\Html;

/**
 * @var $content string
 * @var $this \yii\web\View
 */
\app\assets\AppAsset::register($this);
Recaptcha::init($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= Html::encode($this->context->h1title) ?></title>
    <?php $this->registerCsrfMetaTags() ?>

    <?php $this->context->head()?>
    <?php $this->head() ?>
</head>
<body class="error"  itemscope itemtype="http://schema.org/Organization">
<?php $this->beginBody() ?>
<?php $this->context->beginBody()?>

<?=$this->render('_svg')?>
<?=$this->render('_modals')?>

<main>
    <?=$content?>

    <?=$this->render('_vector')?>
</main>

<?php $this->endBody() ?>
<?php $this->context->endBody()?>
</body>
</html>
<?php $this->endPage() ?>

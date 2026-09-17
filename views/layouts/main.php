<?php
use app\components\recaptcha\Recaptcha;
use app\models\forms\RequestFeedbackForm;
use app\models\SystemSettings;
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
<html lang="ru">
    <head itemscope itemtype="http://schema.org/WPHeader">
        <meta http-equiv='X-UA-Compatible' content='IE=Edge'>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta charset="UTF-8">

        <title itemprop="headline"><?= Html::encode($this->context->seo['seo_title']) ?></title>

        <?php $this->context->head()?>
        <?php $this->head() ?>
        <!-- UIS -->
        <script type="text/javascript" async src="https://app.uiscom.ru/static/cs.min.js?k=WE7ZeCsAg3g3fQKpbM0cTCG01e0pwSCm"></script>
        <!-- UIS -->
    </head>
    <body class="page <?=$this->context->body_class?>" itemscope itemtype="http://schema.org/Organization">
        <?php $this->beginBody() ?>
        <?php $this->context->beginBody()?>

        <?=$this->render('_svg')?>
        <?=$this->render('_header')?>

        <main class="main <?=$this->context->main_class?>">
            <?=$content?>
        </main>

        <?=$this->render('_footer')?>
        <?=$this->render('_modals')?>

        <?php $this->endBody() ?>
        <?php $this->context->endBody()?>
    </body>
</html>
<?php $this->endPage() ?>

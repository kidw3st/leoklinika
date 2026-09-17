<?php
use app\components\recaptcha\Recaptcha;
use app\helpers\base\FormHelper;
use app\models\forms\RequestConsultForm;
use app\models\forms\RequestFeedbackForm;
use app\models\SystemSettings;
use app\widgets\form\FormWidget;

/**
 * @var RequestConsultForm $model
 * @var boolean $success
 * @var array $options
 * @var FormWidget $context
 */

$button = 'Отправить';
if (!empty($options['button'])) $button = $options['button'];

$context = $this->context;
?>

<form class="form popup__content__form" id="<?=$this->context->pjax_id?>" <?=$context->form_attributes?>>
    <?php if ($model->success) { ?>
        <script>
            show_success_modal("<?=$options['success_text']?>");
        </script>
    <?php } ?>
    <?=FormHelper::csrf()?>
    <?=Recaptcha::input($this)?>

    <?php if (!empty($options['title'])) { ?>
        <h4 class="form__title"><?=$options['title']?></h4>
    <?php } ?>
    <div class="form__wrapper">
        <?=$this->render('//components/form/input_text', ['model' => $model, 'attribute' => 'name'])?>
        <?=$this->render('//components/form/textarea', ['model' => $model, 'attribute' => 'text'])?>
        <div class="form__block">
            <?=$this->render('//components/form/input_tel', ['model' => $model, 'attribute' => 'phone'])?>
            <?=$this->render('//components/form/input_email', ['model' => $model, 'attribute' => 'email'])?>
        </div>
        <div class="form__block">
            <?=$this->render('//components/_politika')?>
            <button type="submit" class="form__btn btn btn_primary"><?=$button?></button>
        </div>
    </div>
</form>
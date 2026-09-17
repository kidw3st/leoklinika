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

<form id="<?=$this->context->pjax_id?>" class="form consultation__form" <?=$context->form_attributes?>>
    <?php if ($model->success) { ?>
        <script>
            show_success_modal("<?=$options['success_text']?>");
        </script>
    <?php } ?>
    <?=FormHelper::csrf()?>
    <?=Recaptcha::input($this)?>

    <?php if (!empty($options['title'])) { ?>
        <?php if (!empty($options['title_tag'])) { ?>
            <<?=$options['title_tag']?> class="form__title"><?=$options['title']?></<?=$options['title_tag']?>>
        <?php } else { ?>
            <h4 class="form__title"><?=$options['title']?></h4>
        <?php } ?>
    <?php } ?>
    <?php if (!empty($options['text'])) { ?>
        <p class="form__text bodytext_n_strong"><?=$options['text']?></p>
    <?php } ?>
    <div class="form__wrapper">
        <?=$this->render('//components/form/input_text', ['model' => $model, 'attribute' => 'name'])?>
        <?=$this->render('//components/form/input_tel', ['model' => $model, 'attribute' => 'phone'])?>
        <?=$this->render('//components/form/textarea', ['model' => $model, 'attribute' => 'text'])?>

        <?php if($model->hasErrors()) { ?>
            <div class="form__errors">
                <p class="form-errors">
                    <?=implode('<br/>', $model->firstErrors)?>
                </p>
            </div>
        <?php } ?>

        <button type="submit" class="form__btn btn btn_primary"><?=$button?></button>

        <?=$this->render('//components/_politika')?>
    </div>
</form>
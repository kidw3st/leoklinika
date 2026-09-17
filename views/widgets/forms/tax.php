<?php
use app\components\recaptcha\Recaptcha;
use app\helpers\base\FormHelper;
use app\models\forms\RequestConsultForm;
use app\models\forms\RequestFeedbackForm;
use app\models\forms\RequestTaxDeducationForm;
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
        <?=$this->render('//components/form_span/input_radio', ['model' => $model, 'attribute' => 'patient', 'items' => RequestTaxDeducationForm::patientList()])?>

        <!-- Форма для случая, когда пациент является плательщиком -->
        <div class="payer-is-patient"<?=($model->patient=='1')?'':' style="display: none;'?>>
            <h5 class="form__subtitle">Данные плательщика</h5>
            <div class="form__block">
                <?=$this->render('//components/form_span/input_text', ['model' => $model, 'attribute' => 'base_name'])?>
                <?=$this->render('//components/form_span/input_date', ['model' => $model, 'attribute' => 'base_birthday_input'])?>
            </div>

            <div class="form__block">
                <?=$this->render('//components/form_span/input_text', ['model' => $model, 'attribute' => 'base_inn'])?>
                <?=$this->render('//components/form_span/input_text', ['model' => $model, 'attribute' => 'base_passport'])?>
            </div>


            <div class="form__block">
                <?=$this->render('//components/form_span/input_date', ['model' => $model, 'attribute' => 'base_passport_date_input'])?>
                <?=$this->render('//components/form_span/input_text', ['model' => $model, 'attribute' => 'base_year'])?>
            </div>


        </div>

        <!-- Форма для случая, когда пациент не является плательщиком -->
        <div class="payer-is-not-patient"<?=($model->patient=='0')?'':' style="display: none;'?>>
            <h5 class="form__subtitle">Данные пациента</h5>
            <div class="form__block">
                <?=$this->render('//components/form_span/input_text', ['model' => $model, 'attribute' => 'patient_name'])?>
                <?=$this->render('//components/form_span/input_text', ['model' => $model, 'attribute' => 'relation'])?>
            </div>

            <div class="form__block">
                <?=$this->render('//components/form_span/input_text', ['model' => $model, 'attribute' => 'patient_inn'])?>
                <?=$this->render('//components/form_span/input_date', ['model' => $model, 'attribute' => 'patient_birthday_input'])?>
            </div>

            <div class="form__block">
                <?=$this->render('//components/form_span/input_text', ['model' => $model, 'attribute' => 'patient_passport'])?>
                <?=$this->render('//components/form_span/input_date', ['model' => $model, 'attribute' => 'patient_passport_date_input'])?>
            </div>

            <h5 class="form__subtitle">Данные плательщика</h5>
            <div class="form__block">
                <?=$this->render('//components/form_span/input_text', ['model' => $model, 'attribute' => 'payer_passport'])?>
                <?=$this->render('//components/form_span/input_date', ['model' => $model, 'attribute' => 'payer_passport_date_input'])?>
            </div>

            <div class="form__block">
                <?=$this->render('//components/form_span/input_text', ['model' => $model, 'attribute' => 'payer_name'])?>
                <?=$this->render('//components/form_span/input_date', ['model' => $model, 'attribute' => 'payer_birthday_input'])?>
            </div>

            <div class="form__block">
                <?=$this->render('//components/form_span/input_text', ['model' => $model, 'attribute' => 'payer_inn'])?>
                <?=$this->render('//components/form_span/input_text', ['model' => $model, 'attribute' => 'payer_year'])?>
            </div>
        </div>

        <div class="form__block">
            <?=$this->render('//components/form_span/input_tel', ['model' => $model, 'attribute' => 'phone'])?>
        </div>

        <div class="form__block form__block_radio">
            <?=$this->render('//components/form_span/input_radio2', ['model' => $model, 'attribute' => 'delivery_method', 'items' => RequestTaxDeducationForm::delivery_methodList()])?>
            <div class="email-field"<?=($model->delivery_method=='email')?'':' style="display: none;'?>">
            <?=$this->render('//components/form_span/input_email2', ['model' => $model, 'attribute' => 'email'])?>
        </div>
    </div>

    <div class="form__block">
        <?=$this->render('//components/_politika2')?>
        <button type="submit" class="form__btn btn btn_primary"><?=$button?></button>
    </div>
    </div>
</form>
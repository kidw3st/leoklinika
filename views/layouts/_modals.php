<?php
use app\models\forms\RequestAppointmentForm;
use app\models\forms\RequestCallbackForm;
use app\models\forms\RequestCallDoctorForm;
use app\widgets\form\FormWidget;

/**
 * @var \yii\web\View $this
 */
?>

<?php if (!empty($this->blocks)) { ?>
    <?php foreach ($this->blocks as $key => $block) { ?>
        <?=$block?>
    <?php } ?>
<?php } ?>

<?=$this->render('//components/form_modal', [
    'form_type' => 'call',
    'modal_id' => 'layout_call_doctor',
    'pjax_id' => 'layout_call_doctor',
    'form_class' => RequestCallDoctorForm::class,
    'model' => false,
    'template' => 'form_1',
])?>

<?=$this->render('//components/form_modal', [
    'form_type' => 'callback',
    'modal_id' => 'layout_callback',
    'pjax_id' => 'layout_callback',
    'form_class' => RequestCallbackForm::class,
    'model' => false,
    'template' => 'form_1',
])?>

<?=$this->render('//components/form_modal', [
    'form_type' => 'appointment',
    'modal_id' => 'layout_appointment',
    'pjax_id' => 'layout_appointment',
    'form_class' => RequestAppointmentForm::class,
    'model' => false,
    'template' => 'form_1',
])?>

<div id="media-popup" class="popup popup_media">
    <div class="popup__wrapper">
        <div class="popup__close-area"></div>
        <div class="popup__block">
            <button class="popup__close">
                <svg class="popup__close__icon icon">
                    <use xlink:href="#icon-close"></use>
                </svg>
            </button>
            <div class="popup__top">
                <div class="popup__content">
                    <img src="" alt="" class="popup__media__content">
                    <video src="" alt="" class="popup__media__content" controls></video>
                    <iframe src="" alt="" class="popup__media__content"></iframe>
                </div>
                <div class="popup__navigation">
                    <div class="popup__arrows">
                        <button class="btn popup__arrow popup__arrow_left">
                            <svg class="icon">
                                <use xlink:href="#icon-arrow2"></use>
                            </svg>
                        </button>
                        <button class="btn popup__arrow popup__arrow_right">
                            <svg class="icon">
                                <use xlink:href="#icon-arrow2"></use>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="popup__progress _adaptive">
                    <div class="popup__progressbar">
                        <span class="popup__progressbar__fill"></span>
                    </div>
                </div>
            </div>

            <div class="popup__name popup__media__name megatext_s_strong"></div>
            <div class="popup__text popup__media__text bodytext_l"></div>
        </div>
    </div>
</div>

<div id="cookie" class="popup popup_cookie">
    <p class="popup__text bodytext_m_strong"><?=\app\models\SystemSettings::getParam('common', 'cookie_text', 'Мы используем файлы cookie, чтобы улучшать сайт для Вас. Оставаясь на сайте, Вы соглашаетесь с условиями использования <a href="" class="popup__link">файлов cookie</a>.')?></p>
    <button class="btn btn_primary popup__accept">Согласен</button>
</div>

<div id="review-success" class="popup popup_review-success">
    <span class="_open-popup" data-target-id="review-success" style="display: none"></span>
    <div class="popup__wrapper">
        <div class="popup__close-area"></div>
        <div class="popup__block">
            <div class="popup__content">
                <p class="popup__text bodytext_n_strong text">Спасибо за отзыв.<br>После модерации, ваш отзыв будет опубликован</p>
                <button class="popup__btn btn btn_square btn_primary btn_close">Ок</button>
            </div>
        </div>
    </div>
</div>

<button class="_open-popup success_button" data-target-id="review-success" style="display: none">Успех</button>

<div id="tax" class="popup popup_tax">
    <div class="popup__wrapper">
        <div class="popup__scroll">
            <div class="popup__close-area"></div>
            <div class="popup__block">
                <button class="popup__close">
                    <svg class="popup__close__icon icon">
                        <use xlink:href="#icon-close"></use>
                    </svg>
                </button>
                <div class="popup__content">
                    <div class="popup__content__wrapper">

                        <form class="form popup__content__form" id="" action="" method="POST">
                            <h4 class="form__title">Оставьте заявку на налоговый вычет</h4>
                            <div class="form__wrapper">

                                <div class="form__block">
                                    <fieldset class="radio">
                                        <label class="_active">
                                            <input class="radio__real" type="radio" name="type" id="true" value="1" checked>
                                            <span class="radio__custom"></span>
                                            <span class="radio__text bodytext_m">Пациент является плательщиком</span>
                                        </label>
                                        <label>
                                            <input class="radio__real" type="radio" name="type" id="false" value="0">
                                            <span class="radio__custom"></span>
                                            <span class="radio__text bodytext_m">Пациент не является плательщиком</span>
                                        </label>
                                    </fieldset>
                                </div>

                                <label class="form__label form__label_name">
                                    <span class="form__label__name bodytext_m">Введите ваши ФИО*</span>
                                    <input class="form__input bodytext_m fio-mask" size="40" name="name" type="text" placeholder="Ваши ФИО" required>
                                </label>

                                <div class="form__block">
                                    <label class="form__label form__label_birthday">
                                        <span class="form__label__name bodytext_m">Введите дату рождения*</span>
                                        <input class="form__input bodytext_m" name="birthday"  type="date" placeholder="Дата рождения пациента" required>
                                    </label>
                                    <label class="form__label form__label_tax-id">
                                        <span class="form__label__name bodytext_m">Введите ИНН пациента*</span>
                                        <input class="form__input bodytext_m" name="tax-id" type="number" placeholder="ИИН пациента" required>
                                    </label>
                                </div>

                                <div class="form__block">
                                    <label class="form__label form__label_card">
                                        <span class="form__label__name bodytext_m">Введите номер амбулаторной карты</span>
                                        <input class="form__input bodytext_m" name="card" type="text" placeholder="Номер амбулаторной карты">
                                    </label>
                                    <label class="form__label form__label_year">
                                        <span class="form__label__name bodytext_m">За какой год / годы вы хотите получить справку *</span>
                                        <input class="form__input bodytext_m" name="year" type="number" placeholder="Годы" required>
                                    </label>
                                </div>

                                <div class="form__block">
                                    <label class="form__label form__label_email">
                                        <span class="form__label__name bodytext_m">Укажите почту, на которую нужно выслать справку*</span>
                                        <input class="form__input bodytext_m mail-mask" size="40" name="email" type="email" placeholder="pochta@pochta.ru" required>
                                    </label>
                                    <label class="form__label form__label_phone">
                                        <span class="form__label__name bodytext_m">Введите ваш номер телефона</span>
                                        <input class="form__input bodytext_m phone-mask" size="20" name="phone" type="text" placeholder="+7(___) ___-__-__">
                                    </label>
                                </div>

                                <div class="form__block">
                                    <label class="form__label form__label_checkbox">
                                        <input type="checkbox" name="titles" class="checkbox_real" required>
                                        <span class="checkbox_custom"></span>
                                        <span class="form__label__name bodytext_m">Нажимая на кнопку, вы соглашаетесь с
                                                <a href="#" class="form__link">политикой обработки персональных данных</a>
                                            </span>
                                    </label>
                                    <button type="submit" class="form__btn btn btn_primary">Заказать справку</button>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
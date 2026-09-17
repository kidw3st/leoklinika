<?php
use app\helpers\base\TextHelper;
use app\models\FormSetting;
use app\models\SystemSettings;
use app\widgets\form\FormWidget;

/**
 * @var string $form_type
 * @var string $modal_id
 * @var string $pjax_id
 * @var \app\components\base\CActiveRecord $model
 * @var string $form_class
 * @var string $template
 */

$form_settings = FormSetting::getFormSettings($form_type);
if (empty($model)) $model = new $form_class();

if (!empty($form_image)) {
    $form_settings->image = $form_image;
    $form_settings->video_id = null;
}
if (!empty($form_video_id)) $form_settings->video_id = $form_video_id;
?>

<?php if ($form_settings) { ?>
    <div id="<?=$modal_id?>" class="popup popup_doctor">
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
                            <div class="popup__content__left">
                                <?php if ($form_settings->video) { ?>
                                    <video class="popup__content__video" muted loop playsinline autoplay>
                                        <source src="<?=TextHelper::ImgUrl($form_settings->video->video)?>" type="video/mp4">
                                    </video>
                                <?php } else { ?>
                                    <img class="popup__content__image" src="<?=TextHelper::ImgUrl($form_settings->image_obj->doCrop(466, 546))?>" alt="<?=TextHelper::Alt($form_settings->form_name)?>">
                                <?php } ?>
                            </div>
                            <div class="popup__content__right">
                                <?=FormWidget::widget([
                                    'id' => $pjax_id,
                                    'pjax' => true,
                                    'pjax_block_auto' => false,
                                    'model' => $model,
                                    'template' => '//widgets/forms/'.$template,
                                    'options' => [
                                        'title' => $form_settings->title,
                                        'text' => $form_settings->description,
                                        'button' => $form_settings->link_title,
                                        'success_text' => SystemSettings::getParam('form_' . $form_type, 'success_text', 'Спасибо!'),
                                    ],
                                ])?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php
use app\helpers\base\TextHelper;
use app\models\FormSetting;
use app\models\SystemSettings;
use app\widgets\form\FormWidget;

/**
 * @var string $form_type
 * @var string $pjax_id
 * @var string $form_class
 * @var \app\components\base\CActiveRecord $model
 * @var string $template
 * @var string $section_class
 * @var array $options
 */

if (empty($section_class)) $section_class = '';
$form_settings = FormSetting::getFormSettings($form_type);
if (empty($model)) $model = new $form_class();
if (empty($options)) $options = [];

if (!empty($form_image)) {
    $form_settings->image = $form_image;
    $form_settings->video_id = null;
}
if (!empty($form_video_id)) $form_settings->video_id = $form_video_id;
if (empty($options['success_text']) && !empty($form_settings->success_text)) {
    $options['success_text'] = $form_settings->success_text;
}
if (empty($options['success_text'])) {
    $options['success_text'] = 'Спасибо!';
}
?>

<?php if ($form_settings) { ?>
    <section class="consultation <?=$section_class?>">
        <div class="container">
            <div class="consultation__wrapper">
                <div class="consultation__left">
                    <?=FormWidget::widget([
                        'id' => $pjax_id,
                        'pjax' => true,
                        'pjax_block_auto' => false,
                        'model' => $model,
                        'template' => '//widgets/forms/'.$template,
                        'options' => array_merge([
                            'title' => $form_settings->title,
                            'text' => $form_settings->description,
                            'button' => $form_settings->link_title,
                        ], $options),
                    ])?>
                </div>
                <div class="consultation__right">
                    <?php if ($form_settings->video) { ?>
                        <video class="consultation__video" muted loop playsinline autoplay>
                            <source src="<?=TextHelper::ImgUrl($form_settings->video->video)?>" type="video/mp4">
                        </video>
                    <?php } else { ?>
                        <img class="consultation__image" src="<?=TextHelper::ImgUrl($form_settings->image_obj->doCrop(680, 815))?>" alt="<?=TextHelper::Alt($form_settings->title)?>"/>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
<?php } ?>
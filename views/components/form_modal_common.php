<?php
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
 * @var string $popup_class
 */
?>

<div id="<?=$modal_id?>" class="popup <?=$popup_class?>">
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
                        <?=FormWidget::widget([
                            'id' => $pjax_id,
                            'pjax' => true,
                            'pjax_block_auto' => false,
                            'model' => $model,
                            'template' => '//widgets/forms/'.$template,
                            'options' => [
                                'title' => $title,
                                'button' => $button,
                                'success_text' => $success_text,
                            ],
                        ])?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
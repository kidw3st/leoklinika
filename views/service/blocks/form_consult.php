<?php
/**
 * @var \app\models\Service $service
 * @var \app\models\ServiceBlock $block
 */
use app\models\forms\RequestConsultForm;

?>

<?=$this->render('//components/form_inline', [
    'form_type' => 'consult_services',
    'pjax_id' => 'service_consult_detail_'.$block->id,
    'model' => new RequestConsultForm(['service_id' => $service->id]),
    'form_class' => RequestConsultForm::class,
    'template' => 'consult',
    'section_class' => 'consultation_thin',
    'options' => [
        'title_tag' => 'h5',
    ],
])?>
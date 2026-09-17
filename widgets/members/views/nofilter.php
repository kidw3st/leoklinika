<?php
use app\assets\PjaxAsset;
use app\helpers\base\SystemHelper;
use app\helpers\base\TextHelper;
use app\models\forms\RequestAppointmentForm;
use app\models\SystemSettings;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var string $link_all
 * @var \app\models\MemberDirect[] $tags
 * @var string $current_tag
 * @var string $section_class
 * @var \app\models\Member[] $members
 * @var string $pjax_id
 * @var array $options
 */

PjaxAsset::register($this);
$medflex_token = SystemSettings::getParam('common', 'medflex_token');
?>

<?php if($members) { ?>
    <section class="doctors <?=$section_class?>" id="<?=$pjax_id?>">
        <div class="container">
            <div class="swiper swiper_template">
                <div class="doctors__head">
                    <h2 class="doctors__title <?=$this->context->title_class?>"><?=$title?></h2>
                    <div class="swiper-navigation swiper-navigation_top">
                        <div class="swiper-arrows">
                            <button class="swiper-button swiper-button-prev button">
                                <svg class="icon">
                                    <use xlink:href="#icon-arrow2"></use>
                                </svg>
                            </button>
                            <button class="swiper-button swiper-button-next button">
                                <svg class="icon">
                                    <use xlink:href="#icon-arrow2"></use>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="swiper-wrapper">
                    <?php foreach ($members as $member) { ?>
                        <div class="swiper-slide">
                            <?=$this->render('//members/_item', ['item' => $member, 'medflex_token' => $medflex_token])?>
                        </div>
                    <?php } ?>
                </div>
                <div class="swiper-navigation swiper-navigation_bottom">
                    <div class="swiper-pagination"></div>
                </div>
                <a class="doctors__more btn btn_link_arrow bodytext_n_strong" href="<?=$link_all?>"><?=!empty($options['link_title'])?$options['link_title']:'Смотреть всех врачей'?></a>
            </div>

        </div>
    </section>

    <?php foreach ($members as $member) { ?>
        <?php $this->beginBlock('modal-appointment_member_'.$member->id)?>
            <?=$this->render('//components/form_modal', [
                'form_type' => 'appointment_member',
                'form_image' => $member->modal_image,
                'form_video_id' => $member->modal_video_id,
                'modal_id' => 'appointment_member_' . $member->id,
                'pjax_id' => 'appointment_member_' . $member->id,
                'form_class' => RequestAppointmentForm::class,
                'model' => new RequestAppointmentForm(['member_id' => $member->id]),
                'template' => 'form_1',
            ])?>
        <?php $this->endBlock()?>
    <?php } ?>
<?php } ?>
<?php
use app\models\forms\RequestAppointmentForm;

/**
 * @var \app\models\ServicePrice[] $prices
 */
?>

<ul class="pricelist__list">
    <?php foreach ($prices as $price) { ?>
        <li class="pricelist__item">
            <p class="pricelist__item__name bodytext_l"><?=$price->title?></p>
            <div class="pricelist__item__right">
                <?php if($price->actions) { ?>
                    <div class="pricelist__item__right__wrapper">
                        <div class="pricelist__item__flash">
                            <svg class="icon">
                                <use xlink:href="#icon-flash"></use>
                            </svg>
                            <?php if(!empty($price->actions[0]->title2)) { ?>
                                <p class="pricelist__item__flash__text bodytext_m_strong"> <?=$price->actions[0]->title2?></p>
                            <?php } ?>
                        </div>
                        <p class="pricelist__item__price bodytext_l_strong"><?=$price->price_from?'от ':''?><?=intval($price->price)?> ₽</p>
                    </div>
                <?php } else { ?>
                    <p class="pricelist__item__price bodytext_l_strong"><?=$price->price_from?'от ':''?><?=intval($price->price)?> ₽</p>
                <?php } ?>
                <button class="pricelist__item__btn bodytext_l_strong _open-popup" data-target-id="appointment_pricelist_<?=$price->id?>">Записаться на приём</button>
            </div>
        </li>
    <?php } ?>
</ul>

<?php foreach ($prices as $price) { ?>
    <?php $this->beginBlock('modal-appointment_pricelist_'.$price->id)?>
        <?=$this->render('//components/form_modal', [
            'form_type' => 'appointment',
            'modal_id' => 'appointment_pricelist_' . $price->id,
            'pjax_id' => 'appointment_pricelist_' . $price->id,
            'form_class' => RequestAppointmentForm::class,
            'model' => new RequestAppointmentForm(['price_id' => $price->id]),
            'template' => 'form_1',
        ])?>
    <?php $this->endBlock()?>
<?php } ?>

<?php
/**
 * @var \app\models\Service $service
 * @var \app\models\ServiceBlock $block
 */
use app\models\forms\RequestConsultForm;

?>

<?php if(!empty($service->pricelist)) { ?>
    <section class="pricelist">
        <div class="container">
            <div class="pricelist__filter"></div>
            <h2 class="pricelist__title">Стоимость приёма и процедур</h2>

            <div class="pricelist__wrapper">
                <?=$this->render('//service/_pricelist_accordion', ['pricelist' => $service->pricelist])?>
            </div>

            <a class="pricelist__more btn btn_link_arrow bodytext_n_strong" href="<?=Yii::$app->urlManager->createUrl(['price/index'])?>">Смотреть все цены</a>
        </div>
    </section>
<?php } ?>
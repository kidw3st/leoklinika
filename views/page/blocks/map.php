<?php
use app\helpers\base\TextHelper;
use app\models\Filial;
use app\models\Page;
use app\models\PageBlock;
use app\models\SystemSettings;

/**
 * @var Page $item
 * @var PageBlock $block
 * @var Filial[] $filials
 * @var Filial $current_filial
 */

$current_filial = Filial::getCurrent();
$filials = Filial::find()->published()->ordered()->all();
?>

<?php if($filials) { ?>
    <section class="contacts">
        <div class="container">
            <?php if($block->show_title) { ?>
                <h2 class="contacts__block__title"><?=$block->title?></h2>
            <?php } ?>
            <div class="contacts__wrapper">
                <div class="contacts__map">
                    <div class="contacts__map__block" id="map"></div>
                </div>

                <div class="contacts__block _active">
                    <h2 class="contacts__title megatext_n">Контакты</h2>

                    <span class="contacts__block__btn _active">
                        <svg class="icon" width="24" height="24">
                            <use xlink:href="#icon-double-arrow"></use>
                        </svg>
                    </span>

                    <div class="contacts__content">
                        <div class="contacts__subtitle bodytext_n_strong">
                            <span class="circle">
                                <svg class="icon" width="13" height="18">
                                    <use xlink:href="#icon-contact-geo"></use>
                                </svg>
                            </span>
                            <span>Адреса филиалов</span>
                        </div>

                        <ul class="contacts__list">
                            <?php foreach ($filials as $filial) { ?>
                                <li class="contacts__item" data-coord="<?=$filial->coord_x?>, <?=$filial->coord_y?>">
                                    <div class="contacts__item__address bodytext_l">
                                        <?=$filial->full_title?>
                                        <span class="contacts__item__show bodytext_m">показать</span>
                                    </div>

                                    <div class="contacts__item__balloon">
                                        <span><?=SystemSettings::getParam('common', 'filial_company_name', 'MEDICAL')?></span><?=$filial->full_title?>
                                    </div>

                                    <div class="contacts__item__detail">
                                        <span class="contacts__item__back bodytext_m">
                                            <svg class="icon" width="11" height="20">
                                                <use xlink:href="#icon-arrow3"></use>
                                            </svg>
                                            Назад
                                        </span>
                                        <div class="contacts__content">
                                            <div class="contacts__subtitle bodytext_n_strong">
                                                <span class="circle">
                                                    <svg class="icon" width="13" height="18">
                                                        <use xlink:href="#icon-contact-geo"></use>
                                                    </svg>
                                                </span>
                                                <span><?=$filial->title?></span>
                                            </div>
                                            <div class="contacts__item__address bodytext_l"><?=$filial->full_title?></div>
                                            <?php if(!empty($filial->phones_arr)) { ?>
                                                <div class="contacts__subtitle bodytext_n_strong">
                                                    <span class="circle">
                                                        <svg class="icon" width="16" height="16">
                                                            <use xlink:href="#icon-contact-phone"></use>
                                                        </svg>
                                                    </span>
                                                    <span>Контактный номер</span>
                                                </div>
                                                <a class="contacts__text bodytext_l" href="tel:<?=TextHelper::tel($filial->phones_arr[0])?>"><?=$filial->phones_arr[0]?></a>
                                            <?php } ?>
                                            <?php if(!empty($filial->emails_arr)) { ?>
                                                <div class="contacts__subtitle bodytext_n_strong">
                                                    <span class="circle">
                                                        <svg class="icon" width="17" height="16">
                                                            <use xlink:href="#icon-contact-mail"></use>
                                                        </svg>
                                                    </span>
                                                    <span>Email</span>
                                                </div>
                                                <a class="contacts__text bodytext_l" href="mailto:<?=$filial->emails_arr[0]?>"><?=$filial->emails_arr[0]?></a>
                                            <?php } ?>
                                            <div class="contacts__subtitle bodytext_n_strong">
                                                <span class="circle">
                                                    <svg class="icon" width="17" height="16">
                                                        <use xlink:href="#icon-contact-mail"></use>
                                                    </svg>
                                                </span>
                                                <span>Часы работы</span>
                                            </div>
                                            <div class="contacts__text bodytext_l">
                                                <?=implode('<br>', $filial->times_res)?>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>

                        <span class="contacts__list__show bodytext_m_strong" style="display: none;">
                            Показать еще
                            <svg class="icon" width="24" height="24">
                                <use xlink:href="#icon-arrow1"></use>
                            </svg>
                        </span>

                        <?php if(!empty($current_filial->phones_arr[0])) { ?>
                            <div class="contacts__subtitle bodytext_n_strong">
                                <span class="circle">
                                    <svg class="icon" width="16" height="16">
                                        <use xlink:href="#icon-contact-phone"></use>
                                    </svg>
                                </span>
                                <span>Контактный номер</span>
                            </div>

                            <a class="contacts__text bodytext_l" href="tel:<?=TextHelper::tel($current_filial->phones_arr[0])?>"><?=$current_filial->phones_arr[0]?></a>
                        <?php } ?>

                        <?php if(!empty($current_filial->emails_arr[0])) { ?>
                            <div class="contacts__subtitle bodytext_n_strong">
                                <span class="circle">
                                    <svg class="icon" width="17" height="16">
                                        <use xlink:href="#icon-contact-mail"></use>
                                    </svg>
                                </span>
                                <span>Email</span>
                            </div>

                            <a class="contacts__text bodytext_l" href="mailto:<?=$current_filial->emails_arr[0]?>"><?=$current_filial->emails_arr[0]?></a>
                        <?php } ?>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU"></script>
    <script>
        const mapWrapper = document.querySelector('.contacts__wrapper')
        const adresses = mapWrapper?.querySelectorAll('.contacts__list > .contacts__item')
        const mapBlock = document.getElementById('map')
        if (mapBlock) {
            ymaps.ready(function init() {

                let center = adresses[0].getAttribute('data-coord').split(',');
                center = [parseFloat(center[0]), parseFloat(center[1])];
                let placemarkArr = [];

                let map = new ymaps.Map("map", {
                    center: center,
                    zoom: 13,
                    controls: []
                }, {
                    // autoFitToViewport: 'always'
                });

                // Если нужна кастомная иконки метки, создаем шаблон метки:
                CustomIconLayout = ymaps.templateLayoutFactory.createClass('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="12" fill="#AE846F"/><circle cx="12" cy="12" r="8" fill="#F5F5FA"/></svg>');

                adresses.forEach((item, index) => {
                    let coord = item.getAttribute('data-coord').split(',');
                coord = [parseFloat(coord[0]), parseFloat(coord[1])];
                let placemark = new ymaps.Placemark(coord, {
                    balloonContentBody: '<div class="contacts__item__balloon">' + item.querySelector('.contacts__item__balloon').innerHTML + '</div>',
                }, {
                    // iconLayout: 'default#image',
                    // iconImageHref: './images/icons/map-icon.svg',
                    // iconImageSize: [48, 48],
                    // iconImageOffset: [-24, -24],
                    iconLayout: CustomIconLayout,
                    iconShape: {
                        type: 'Circle',
                        coordinates: [0, 0],
                        radius: 25
                    },
                    balloonCloseButton: false,
                    hideIconOnBalloonOpen: false,
                    gridSize: 32,
                    clusterDisableClickZoom: true,
                    balloonOffset: [-50, -50],
                });
                map.geoObjects.add(placemark);

                placemarkArr.push(placemark)

                item.addEventListener('click', () => {
                    map.setCenter(coord)
                placemark.balloon.open()
            })
            });

                map.events.add('click', e => {
                    e.get('target').balloon.close()
            });
            });
        }
    </script>
<?php } ?>
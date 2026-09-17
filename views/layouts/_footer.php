<?php
use app\helpers\base\MenuHelper;
use app\helpers\base\TextHelper;
use app\models\Filial;
use app\models\Service;
use app\models\Social;
use app\models\SystemSettings;

$filial = Filial::getCurrent();
//$services = Service::find_base()->published()->orderBy('lft ASC')->published()->limit(5)->all();
$socials = Social::find()->published()->ordered()->all();
?>
<footer class="footer" itemscope itemtype="http://schema.org/WPFooter">
    <div class="container">
        <div class="footer__top">
            <div class="footer__left">
                <a href="#" class="footer__logo">
                    <img src="<?=TextHelper::ImgUrl(SystemSettings::getParam('common', 'footer_logo', false, false, 4))?>" alt="logo" class="footer__logo__image">
                </a>
                <?php if($filial) { ?>
                    <div class="footer__contacts">
                        <p class="footer__contacts__address bodytext_m"><?=$filial->title?></p>
                        <?php if (!empty($filial->phones_arr)) { ?>
                            <?php foreach ($filial->phones_arr as $phone) { ?>
                                <a href="tel:<?=TextHelper::tel($phone)?>" class="footer__contacts__phone bodytext_m"><?=$phone?></a>
                            <?php } ?>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
            <div class="footer__center">
                <div class="footer__center__col">
                    <p class="footer__center__col__title bodytext_l_strong">Навигация</p>
                    <?=MenuHelper::draw('bottom', '@app/views/components/menu/bottom')?>
                </div>
                <div class="footer__center__col">
                    <p class="footer__center__col__title bodytext_l_strong">Популярные услуги</p>
                    <?=MenuHelper::draw('bottom2', '@app/views/components/menu/bottom')?>
                </div>
            </div>
            <div class="footer__right">
                <button class="footer__btn btn btn_primary _open-popup" data-target-id="layout_callback">Обратный звонок</button>
                <?php if ($socials) { ?>
                    <div class="footer__social">
                        <?php foreach ($socials as $social) { ?>
                            <a href="<?=$social->link?>" target="_blank" rel="nofollow" class="footer__social__item footer__social__<?=$social->type?>">
                                <svg class="icon">
                                    <use xlink:href="#icon-<?=$social->type?>"></use>
                                </svg>
                            </a>
                        <?php } ?>
                    </div>
                <?php } ?>
                <!-- <a href="https://alente.ru" target="_blank" rel="nofollow" class="footer__developer">
                    <svg class="icon">
                        <use xlink:href="#icon-alente"></use>
                    </svg>
                </a> -->
            </div>
        </div>
        <div class="footer__middle">
            <div class="footer__left">
                <p class="footer__copyright bodytext_m"><?=SystemSettings::getParam('common', 'copyright', '© Все права защищены 2004 — 2023.')?></p>
            </div>
            <!-- <div class="footer__center">
                <p class="footer__text bodytext_m"><?=SystemSettings::getParam('common', 'company', 'ООО «Медикал», сеть семейных поликлиник «Медикал»')?></p>
            </div> -->
            <div class="footer__right">
                <?=MenuHelper::draw('list', '@app/views/components/menu/list')?>
            </div>
        </div>
        <div class="footer__bottom">
            <p class="footer__warning"><?=SystemSettings::getParam('common', 'warning', 'имеются противопоказания, необходима консультация специалиста')?></p>
        </div>
    </div>
</footer>

<a class="top__btn" href="#page_top">
    <svg class="icon">
        <use xlink:href="#icon-arrow"></use>
    </svg>
</a>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Инициализация всплывающих окон Medflex
        var medflexButtons = document.querySelectorAll('._medflex_popup');

        medflexButtons.forEach(function(button) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                var widgetButton = document.querySelector('.medflex-round-widget__button');
                if (widgetButton) {
                    widgetButton.click();
                } else {
                    window.open('<?=SystemSettings::getParam('service', 'medflex_link', 'https://booking.medflex.ru/?user=4eb68eb57d5a93470357e68396406acb&isRoundWidget=true&filial=18600')?>', '_blank');
                }
            });
        });
    });
</script>

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function(m,e,t,r,i,k,a){
        m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();
        for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
        k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)
    })(window, document,'script','https://mc.yandex.ru/metrika/tag.js', 'ym');

    ym(96249294, 'init', {webvisor:true, clickmap:true, referrer: document.referrer, url: location.href, accurateTrackBounce:true, trackLinks:true});
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/96249294" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->



<div id="medflexRoundWidgetData" data-src="https://booking.medflex.ru/?user=4eb68eb57d5a93470357e68396406acb&isRoundWidget=true"></div> <script defer src="https://booking.medflex.ru/components/round/round_widget_button.js" charset="utf-8"></script>
<?php
use app\helpers\base\MenuHelper;
use app\helpers\base\TextHelper;
use app\models\Filial;
use app\models\SystemSettings;

/** @var Filial[] $filials */

$filial = Filial::getCurrent();
$filials = Filial::find()->published()->ordered()->all();
$login_link = SystemSettings::getParam('common', 'lk_link', '');
$logo_text = SystemSettings::getParam('common', 'header_logo_text', 'Медицинский центр');
$medflex_token = SystemSettings::getParam('common', 'medflex_token');
$call_button_link = SystemSettings::getParam('common', 'call_button_link', '');
?>
<div id="page_top"></div>
<div id="medflexRoundWidgetData" data-src="https://booking.medflex.ru?user=4eb68eb57d5a93470357e68396406acb&isRoundWidget=true"></div>
<header class="header header_1 _desktop">
    <div class="header__top">
        <div class="container">
            <div class="header__left">
                <a href="/" class="header__logo<?=empty($logo_text)?' header__logo_full':''?>">
                    <img src="<?=TextHelper::ImgUrl(SystemSettings::getParam('common', 'header_logo', false, false, 4))?>" alt="logo" class="header__logo__image">
                    <?php if(!empty($logo_text)) { ?>
                        <!-- <p class="header__logo__text bodytext_m_strong"><?=$logo_text?></p> -->
                    <?php } ?>
                </a>
                <?php if($filial) { ?>
                    <div class="header__left__wrapper">
                        <div class="header__address bodytext_l_strong">
                            <svg class="icon">
                                <use xlink:href="#icon-geo"></use>
                            </svg>
                            <div class="dropdown">
                                <button class="dropdown__btn">
                                    <span href="<?=$filial->changeUrl?>" class="dropdown__current bodytext_m_strong"><?=$filial->full_title?></span>
                                </button>
                                <?php if ($filials) { ?>
                                    <ul class="dropdown__list">
                                        <?php foreach ($filials as $item) { ?>
                                            <li class="dropdown__item" data-value="<?=$item->id?>">
                                                <a href="<?=$item->changeUrl?>" class="dropdown__link bodytext_m_strong"><?=$item->full_title?></a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                <?php } ?>
                                <input type="text" name="select" value="krsk" class="dropdown__input_hidden">
                            </div>
                        </div>
                        <div class="header__time bodytext_s_strong header__time_<?=$filial->status_code?>">
                            <svg class="icon">
                                <use xlink:href="#icon-clock"></use>
                            </svg>
                            <span><?=$filial->status_text?></span>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <div class="header__right">
                <div class="header__right__wrapper">
                    <?php if ($filial && !empty($filial->phones_arr)) { ?>
                        <a href="tel:<?=TextHelper::tel($filial->phones_arr[0])?>" class="header__phone">
                            <svg class="icon">
                                <use xlink:href="#icon-phone"></use>
                            </svg>
                            <span class="bodytext_l"><?=$filial->phones_arr[0]?></span>
                        </a>
                    <?php } ?>
                    <?php if (!empty($medflex_token)) { ?>
                        <a class="header__sign-up" href="https://booking.medflex.ru?user=<?=$medflex_token?>&source=3" target="_blank">
                            <svg class="icon">
                                <use xlink:href="#icon-calendar"></use>
                            </svg>
                            <span class="bodytext_l">Записаться на приём</span>
                        </a>
                    <?php } else { ?>                    
                    <button class="header__sign-up _open-popup" data-target-id="layout_appointment">
                        <svg class="icon">
                            <use xlink:href="#icon-calendar"></use>
                        </svg>
                        <span class="bodytext_l">Записаться на приём</span>
                    </button>
                    <?php } ?>
                </div>
                <? if ($call_button_link) { ?> 
                  <a class="header__btn btn btn_primary btn_primary_small" href="<?=$call_button_link?>" target="_blank"><?=SystemSettings::getParam('common', 'call_button', 'Вызвать врача')?></a>
                <?php } else { ?> 
                  <button class="header__btn btn btn_primary btn_primary_small _open-popup" data-target-id="layout_call_doctor"><?=SystemSettings::getParam('common', 'call_button', 'Вызвать врача')?></button>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="header__bottom container">
        <div class="header__bottom__wrapper">
            <div class="header__left">
                <div class="header__menu">
                    <?=MenuHelper::draw('top', '@app/views/components/menu/top')?>
                </div>
            </div>
            <div class="header__right">
                <button class="header__bvi">
                    <svg class="icon">
                        <use xlink:href="#icon-bvi"></use>
                    </svg>
                </button>
                <div class="header__search">
                    <svg class="icon">
                        <use xlink:href="#icon-search"></use>
                    </svg>
                    <form class="header__search__form" action="<?=Yii::$app->urlManager->createUrl(['service/index'])?>" method="get">
                        <input class="header__search__input" name="search" type="text" placeholder="Поиск по услугам" />
                        <button class="header__search__btn" type="submit">
                            <svg class="icon">
                                <use xlink:href="#icon-search"></use>
                            </svg>
                        </button>
                    </form>
                </div>
                <?php if(!empty($login_link)) { ?>
                    <a href="<?=$login_link?>" target="_blank" rel="nofollow" class="header__user">
                        <svg class="icon">
                            <use xlink:href="#icon-user"></use>
                        </svg>
                    </a>
                <?php } elseif(!empty($medflex_token)) { ?>
                    <div id="medflexMedtochkaWidgetButton" data-src="https://booking.medflex.ru/?user=<?=$medflex_token?>"></div>
                    <script defer src="https://booking.medflex.ru/components/medtochka-button/medtochka-widget-button.js" charset="utf-8"></script>
                <?php } ?>
            </div>
        </div>
    </div>
</header>

<header class="header _fixed">
    <div class="container">
        <div class="header__left">
            <a href="/" class="header__logo">
                <img src="<?=TextHelper::ImgUrl(SystemSettings::getParam('common', 'header_logo', false, false, 4))?>" alt="logo" class="header__logo__image">
            </a>
            <div class="header__menu">
                <?=MenuHelper::draw('top', '@app/views/components/menu/top')?>
            </div>
        </div>
        <div class="header__right">
            <div class="header__right__wrapper">
                <?php if ($filial && !empty($filial->phones_arr)) { ?>
                    <a href="tel:<?=TextHelper::tel($filial->phones_arr[0])?>" class="header__phone">
                        <svg class="icon">
                            <use xlink:href="#icon-phone"></use>
                        </svg>
                    </a>
                <?php } ?>
                <?php if (!empty($medflex_token)) { ?>
                    <a href="https://booking.medflex.ru?user=<?=$medflex_token?>&source=3" class="header__sign-up" target="_blank">
                        <svg class="icon">
                            <use xlink:href="#icon-calendar"></use>
                        </svg>
                    </a>
                <?php } else { ?>                
                    <button class="header__sign-up _open-popup" data-target-id="layout_appointment">
                        <svg class="icon">
                            <use xlink:href="#icon-calendar"></use>
                        </svg>
                    </button>
                <?php } ?>
            </div>
            <? if ($call_button_link) { ?> 
              <a class="header__btn btn btn_primary btn_primary_small" href="<?=$call_button_link?>" target="_blank"><?=SystemSettings::getParam('common', 'call_button', 'Вызвать врача')?></a>
            <?php } else { ?>
              <button class="header__btn btn btn_primary btn_primary_small _open-popup" data-target-id="layout_call_doctor"><?=SystemSettings::getParam('common', 'call_button', 'Вызвать врача')?></button>
            <?php } ?>
        </div>
    </div>
</header>

<header class="header _adaptive">
    <div class="header__top">
        <div class="container">
            <div class="header__left">
                <a href="/" class="header__logo<?=empty($logo_text)?' header__logo_full':''?>">
                    <img src="<?=TextHelper::ImgUrl(SystemSettings::getParam('common', 'header_logo', false, false, 4))?>" alt="logo" class="header__logo__image">
                    <?php if(!empty($logo_text)) { ?>
                        <!-- <p class="header__logo__text bodytext_m_strong"><?=$logo_text?></p> -->
                    <?php } ?>
                </a>
            </div>
            <div class="header__right">
                <a href="#" class="bvi-shoppanel"><i class="bvi-images bvi-images-eye bvi-images-size-32 bvi-no-styles bvi-background-image"></i></a>

                <?php if ($filial && !empty($filial->phones_arr)) { ?>
                    <a href="tel:<?=TextHelper::tel($filial->phones_arr[0])?>" class="header__phone">
                        <svg class="icon">
                            <use xlink:href="#icon-phone"></use>
                        </svg>
                    </a>
                <?php } ?>
                <?php if (!empty($medflex_token)) { ?>
                    <a href="https://booking.medflex.ru?user=<?=$medflex_token?>&source=3" class="header__sign-up" target="_blank">
                        <svg class="icon">
                            <use xlink:href="#icon-calendar"></use>
                        </svg>
                    </a>
                <?php } else { ?>
                    <button class="header__sign-up _open-popup" data-target-id="layout_appointment">
                        <svg class="icon">
                            <use xlink:href="#icon-calendar"></use>
                        </svg>
                    </button>
                <?php } ?>
                <button class="header__menu-btn _open-menu">
                    <span class="line"></span>
                </button>
            </div>
        </div>
    </div>

    <div class="header__bottom">
        <div class="container">
            <div class="header__bottom__wrapper">
                <button class="header__btn btn btn_primary _open-popup" data-target-id="layout_call_doctor"><?=SystemSettings::getParam('common', 'call_button', 'Вызвать врача')?></button>
                <div class="header__bottom__controls">
                    <button class="header__bvi">
                        <svg class="icon">
                            <use xlink:href="#icon-bvi"></use>
                        </svg>
                    </button>
                    <div class="header__search">
                        <svg class="icon">
                            <use xlink:href="#icon-search"></use>
                        </svg>
                        <form class="header__search__form" action="<?=Yii::$app->urlManager->createUrl(['service/index'])?>" method="get">
                            <input class="header__search__input" name="search" type="text" placeholder="Поиск по услугам" />
                            <button class="header__search__btn" type="submit">
                                <svg class="icon">
                                    <use xlink:href="#icon-search"></use>
                                </svg>
                            </button>
                        </form>
                    </div>
                    <?php if(!empty($login_link)) { ?>
                        <a href="<?=$login_link?>" target="_blank" rel="nofollow" class="header__user">
                            <svg class="icon">
                                <use xlink:href="#icon-user"></use>
                            </svg>
                        </a>
                    <?php } elseif (!empty($medflex_token)) { ?>
                        <a href="https://app.medtochka.ru/?lpu_hash=<?=$medflex_token?>&source=lpu_site" target="_blank" rel="nofollow" class="header__user">
                            <svg class="icon">
                                <use xlink:href="#icon-user"></use>
                            </svg>
                        </a>
                    <?php } ?>
                </div>
            </div>

            <div class="header__bottom__address">
                <div class="header__address bodytext_l_strong">
                    <svg class="icon">
                        <use xlink:href="#icon-geo"></use>
                    </svg>
                    <div class="dropdown">
                        <button class="dropdown__btn">
                            <span href="<?=$filial->changeUrl?>" class="dropdown__current bodytext_m_strong"><?=$filial->full_title?></span>
                        </button>
                        <?php if ($filials) { ?>
                            <ul class="dropdown__list">
                                <?php foreach ($filials as $item) { ?>
                                    <li class="dropdown__item" data-value="<?=$item->id?>">
                                        <a href="<?=$item->changeUrl?>" class="dropdown__link bodytext_m_strong"><?=$item->full_title?></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                        <input type="text" name="select" value="krsk" class="dropdown__input_hidden">
                    </div>
                </div>
                <div class="header__time bodytext_s_strong header__time_<?=$filial->status_code?>">
                    <svg class="icon">
                        <use xlink:href="#icon-clock"></use>
                    </svg>
                    <span><?=$filial->status_text?></span>
                </div>
            </div>

            <div class="header__menu">
                <?=MenuHelper::draw('top', '@app/views/components/menu/top_mobile')?>
            </div>
        </div>
    </div>
</header>

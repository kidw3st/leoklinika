<?php if(!count($menu['children'][$type])) { ?>
    <li class="header__menu__item ">
        <a href="<?=$menu['url']?>" class="header__menu__link bodytext_l_strong">
            <?=$menu['label']?>
        </a>
    </li>
<?php } else { ?>
    <li class="header__menu__item header__menu__item_parent">
        <a href="#" class="header__menu__link bodytext_l_strong">
            <?=$menu['label']?>
            <svg class="icon">
                <use xlink:href="#icon-arrow1"></use>
            </svg>
        </a>

        <div class="header__submenu">
            <div class="header__submenu__head">
                <h5 class="header__submenu__title"><?=$menu['label_2']?></h5>
                <a href="<?=$menu['url']?>" class="header__submenu__link"><?=$menu['label_3']?></a>

                <button class="popup__close">
                    <svg class="popup__close__icon icon">
                        <use xlink:href="#icon-close"></use>
                    </svg>
                </button>
            </div>

            <div class="header__submenu__wrapper">
                <?=$content?>
            </div>
        </div>
    </li>
<?php } ?>
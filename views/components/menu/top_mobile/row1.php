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
            <a href="<?=$menu['url']?>" class="header__submenu__link"><?=$menu['label_2']?></a>
        </a>

        <div class="header__submenu">
            <div class="header__submenu__wrapper">
                <?=$content?>
            </div>
        </div>
    </li>
<?php } ?>
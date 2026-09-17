<li class="header__submenu__category__child">
    <a href="<?=$menu['url']?>" class="header__submenu__category__name bodytext_l_strong"><?=$menu['label']?></a>
    <?php if(count($menu['children'][$type])) { ?>
        <div class="header__submenu__category__wrapper">
            <?=$content?>
        </div>
    <?php } ?>
</li>
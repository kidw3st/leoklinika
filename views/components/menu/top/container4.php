<ul class="header__submenu__category__sublist">
    <?=$content?>
</ul>
<?php if ($count > 3) { ?>
    <div class="header__submenu__more">
        <span class="header__submenu__more__title">Еще <?=($count-3)?> </span>
        <span class="header__submenu__more__toggle">Свернуть</span>
        <svg class="icon">
            <use xlink:href="#icon-arrow1"></use>
        </svg>
    </div>
<?php } ?>
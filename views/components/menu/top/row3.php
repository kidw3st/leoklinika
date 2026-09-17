<?php
    global $b, $b_c;

    if (empty($b)) $b = 0;
    if (empty($b_c)) $b_c = 0;

    if ($b > 2) {
        $b = 0;
        $b_c = 0;
    }

    $b_c++;
    $n_c = (ceil(($count)/3) - (((($count - 1) % 3) < $b)?1:0));

    if ($b_c >= $n_c) $b++;
?>
<li class="header__submenu__category__item2 grid__item">
    <a href="<?=$menu['url']?>" class="header__submenu__category__link bodytext_m"><?=$menu['label']?></a>
    <?=$content?>
</li>

<?php if ($b_c >= $n_c && $b <= 2) { $b_c = 0; ?>
    </ul></div><div class="header__submenu__column"><ul>
<?php } ?>
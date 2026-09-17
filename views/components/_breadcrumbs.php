<?php

?>

<?php if (!empty($breadcrumbs)) { ?>
    <div class="breadcrumbs">
        <div class="container">
            <ul class="breadcrumbs__list" itemscope itemtype="https://schema.org/BreadcrumbList">
                <?php foreach ($breadcrumbs as $k => $item) { ?>
                    <?php if ($k == count($breadcrumbs) - 1) { ?>
                        <li class="breadcrumbs__item bodytext_s" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <span itemprop="name"><?=$item['label']?></span>
                        </li>
                    <?php } else { ?>
                        <li class="breadcrumbs__item bodytext_s" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <a class="breadcrumbs__item__link" href="<?=$item['url']?>" title="<?=$item['label']?>" itemprop="item">
                                <span itemprop="name"><?=$item['label']?></span>
                                <meta itemprop="position" content="0">
                            </a>
                        </li>
                    <?php } ?>
                <?php } ?>
            </ul>
        </div>
    </div>
<?php } ?>
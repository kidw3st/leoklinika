<?='<?xml version="1.0" encoding="utf-8"?>'?>

<?php if ($pages > 1 && $page == 0) { ?>
    <sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
        <?php for ($i = 1; $i <= $pages; $i++) { ?>
            <sitemap>
                <loc><?=Yii::$app->urlManager->createAbsoluteUrl([\app\modules\adminbase\Admin::getInstance()->uniqueId . '/system/sitemap/index', 'page' => $i])?></loc>
                <lastmod><?=date('c')?></lastmod>
            </sitemap>
        <?php } ?>
    </sitemapindex>
<?php } else { ?>
    <?php $j = ($pages > 1)?$maxUrls*($page-1):0; ?>
    <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
        <?php for ($i = $j; $i < $j + $maxUrls && $i < count($sitemap); $i++) { $sm = $sitemap[$i]; ?>
            <url>
                <loc><?=$sm['loc']?></loc>
                <lastmod><?=$sm['lastmod']?></lastmod>
                <changefreq><?=$sm['changefreq']?></changefreq>
                <priority><?=$sm['priority']?></priority>
            </url>
        <?php } ?>
    </urlset>
<?php } ?>
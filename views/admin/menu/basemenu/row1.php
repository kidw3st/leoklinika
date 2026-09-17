<li<?=$menu['class']!=''?(' class="'.$menu['class'].'"'):''?>>
    <a class="[menu_<?=$idx?>:active:inactive]" href="<?=$menu['url']?>"<?=$menu['target']?' target="_blank"':''?>><?=$menu['label']?></a>
    <?=$content?>
</li>
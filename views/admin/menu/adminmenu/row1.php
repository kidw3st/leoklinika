<?php if((count($menu['children'][$type]) && !empty($content) || !count($menu['children'][$type])) && $menu['model']->isPermissionsCan()) { ?>
    <li class="<?=count($menu['children'][$type])?'treeview':''?>[menu_<?=$idx?>: active]">
        <a href="<?=$menu['url']?>">
            <?php if(!empty($menu['model']->icon)) { ?>
                <i class="<?=$menu['model']->icon?>"></i>
            <?php } else { ?>
                <i class="fa fa-circle-o"></i>
            <?php } ?>
            <span><?=$menu['label']?></span>
            <?php if(count($menu['children'][$type])) { ?>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            <?php } ?>
        </a>
        <?=$content?>
    </li>
<?php } ?>
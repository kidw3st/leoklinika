<?php
global $list_cnt;

$list_cnt++;
?>
<a href="<?=$menu['url']?>" class="<?=($list_cnt == $count)?'footer__confidentiality':'footer__license'?> bodytext_m"><?=$menu['label']?></a>
<?php

?>

<div class="login-box">
    <div class="login-logo">
        <a href="/admin"><?=Yii::$app->params['admin']['title']?></a>
    </div>
    <div class="login-box-body">
        <p>Действие запрещено</p>
        <?php if(!Yii::$app->user->isGuest) { ?>
            <p><a href="<?=Yii::$app->urlManager->createUrl(['admin/user/logout', 'backurl' => Yii::$app->request->url])?>">Выйти из пользователя</a></p>
        <?php } ?>
    </div>
</div>
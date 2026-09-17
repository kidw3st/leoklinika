<?php
use app\models\forms\AdminLogin;
use app\widgets\socauth\SocAuthWidget;
/* @var $this yii\web\View */
/* @var $model AdminLogin */
/* @var $backurl string */
?>

<div class="login-box">
    <div class="login-logo">
        <a href="/admin"><?=Yii::$app->params['admin']['title']?></a>
    </div>
    <div class="login-box-body">
        <form action="<?=Yii::$app->urlManager->createUrl(['admin/user/login', 'backurl' => $backurl])?>" method="post">
            <div class="form-group has-feedback">
                <input name="<?=$model->formNameWithVar('login')?>" type="text" class="form-control" placeholder="Email" value="<?=$model->login?>" />
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input name="<?=$model->formNameWithVar('password')?>" type="password" class="form-control" placeholder="Пароль" value="<?=$model->password?>" />
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="<?=$model->formNameWithVar('remember')?>"<?=$model->remember?' checked':''?> value="1" /> Запомнить меня
                        </label>
                    </div>
                </div>
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Войти</button>
                </div>
            </div>
            <?php if($model->hasErrors()) { ?>
                <div class="row">
                    <div class="col-xs-12">
                        <?=implode('<br/>', $model->firstErrors)?>
                    </div>
                </div>
            <?php } ?>
        </form>
        <div class="social-auth-links text-center">
            <p>- ИЛИ -</p>
            <p>
                <?=SocAuthWidget::widget([
                    'backUrl' => Yii::$app->request->get('backurl'),
                ])?>
            </p>
        </div>
    </div>
</div>
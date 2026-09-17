<?php
use app\helpers\base\FormHelper;
?>

<form method="POST">
    <?=FormHelper::csrf()?>

    <div>
        <?=FormHelper::label($model, 'login_enter')?>
        <?=FormHelper::input($model, 'login_enter')?>
    </div>

    <div>
        <?=FormHelper::label($model, 'password_enter')?>
        <?=FormHelper::input($model, 'password_enter', 'password')?>
    </div>

    <div>
        <?=FormHelper::label($model, 'remember_me')?>
        <?=FormHelper::input($model, 'remember_me', 'checkbox')?>
    </div>

    <?php if($model->hasErrors()) { ?>
        <div>
            <p><?=implode('</p><p>', $model->firstErrors)?></p>
        </div>
    <?php } ?>

    <button>Войти</button>
</form>
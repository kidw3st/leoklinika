<?php
use yii\helpers\Html;
?>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body with-border">
                    <form method="post" enctype="multipart/form-data">
                        <?=$this->render('//admin/base/form/string_input', ['model' => $model, 'attribute' => 'name'])?>
                        <?=$this->render('//admin/base/form/string_input', ['model' => $model, 'attribute' => 'phone'])?>
                        <?=$this->render('//admin/base/form/string_input', ['model' => $model, 'attribute' => 'email'])?>
                        <?=$this->render('//admin/base/form/string_textarea', ['model' => $model, 'attribute' => 'text'])?>
                        <?=$this->render('//admin/base/form/string_input', ['model' => $model, 'attribute' => 'rating'])?>
                        <?=$this->render('//admin/base/form/file_simple', ['model' => $model, 'attribute' => 'upload_images', 'multiple' => true])?>
                        <button type="submit">Отправить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

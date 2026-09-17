<?php
use yii\db\Migration;
class m241219_000000_gii_create_filial_image_table extends Migration
{
    public function up()
    {
        $this->createTable('filial_image', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'image' => $this->string(255),
            'filial_id' => $this->integer(),
            'public' => $this->boolean(),
            'weight' => $this->integer(),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Изображение', 'model' => 'FilialImage', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('filial_image');
    }
}
<?php
use yii\db\Migration;
class m241219_000000_gii_create_page_block_image_table extends Migration
{
    public function up()
    {
        $this->createTable('page_block_image', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'image' => $this->string(255),
            'video_id' => $this->integer(),
            'page_block_id' => $this->integer(),
            'public' => $this->boolean(),
            'weight' => $this->integer(),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Изображение', 'model' => 'PageBlockImage', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('page_block_image');
    }
}
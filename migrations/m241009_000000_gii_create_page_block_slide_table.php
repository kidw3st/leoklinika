<?php
use yii\db\Migration;
class m241009_000000_gii_create_page_block_slide_table extends Migration
{
    public function up()
    {
        $this->createTable('page_block_slide', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'image' => $this->string(255),
            'image_mobile' => $this->string(255),
            'page_block_id' => $this->integer(),
            'public' => $this->boolean(),
            'weight' => $this->integer(),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Слайд', 'model' => 'PageBlockSlide', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('page_block_slide');
    }
}
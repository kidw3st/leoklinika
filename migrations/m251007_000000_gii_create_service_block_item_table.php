<?php
use yii\db\Migration;
class m251007_000000_gii_create_service_block_item_table extends Migration
{
    public function up()
    {
        $this->createTable('service_block_item', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'text' => $this->text(),
            'link' => $this->string(255),
            'link_title' => $this->string(255),
            'block_color' => $this->string(50),
            'text_modal' => $this->text(),
            'block_id' => $this->integer(),
            'public' => $this->boolean(),
            'weight' => $this->integer(),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Элемент', 'model' => 'ServiceBlockItem', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('service_block_item');
    }
}
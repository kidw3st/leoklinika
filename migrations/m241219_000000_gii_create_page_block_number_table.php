<?php
use yii\db\Migration;
class m241219_000000_gii_create_page_block_number_table extends Migration
{
    public function up()
    {
        $this->createTable('page_block_number', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'number' => $this->string(255),
            'page_block_id' => $this->integer(),
            'public' => $this->boolean(),
            'weight' => $this->integer(),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Показатель', 'model' => 'PageBlockNumber', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('page_block_number');
    }
}
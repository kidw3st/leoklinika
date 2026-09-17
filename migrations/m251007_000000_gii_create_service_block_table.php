<?php
use yii\db\Migration;
class m251007_000000_gii_create_service_block_table extends Migration
{
    public function up()
    {
        $this->createTable('service_block', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'block_type' => $this->string(50),
            'service_id' => $this->integer(),
            'public' => $this->boolean(),
            'weight' => $this->integer(),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Блок', 'model' => 'ServiceBlock', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('service_block');
    }
}
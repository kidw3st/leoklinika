<?php
use yii\db\Migration;
class m241009_000000_gii_create_service_table extends Migration
{
    public function up()
    {
        $this->createTable('service', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'handle' => $this->string(255),
            'icon' => $this->string(255),
            'type' => $this->string(50),
            'section_id' => $this->integer(),
            'public' => $this->boolean(),
            'weight' => $this->integer(),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Услуга', 'model' => 'Service', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('service');
    }
}
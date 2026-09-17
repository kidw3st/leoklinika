<?php
use yii\db\Migration;
class m241108_000000_gii_create_service_price_table extends Migration
{
    public function up()
    {
        $this->createTable('service_price', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'price' => $this->decimal(10, 2),
            'price_from' => $this->boolean(),
            'service_id' => $this->integer(),
            'public' => $this->boolean(),
            'weight' => $this->integer(),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Цена', 'model' => 'ServicePrice', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('service_price');
    }
}
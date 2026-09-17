<?php
use yii\db\Migration;
class m241108_000000_gii_create_service_link_table extends Migration
{
    public function up()
    {
        $this->createTable('service_link', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'image' => $this->string(255),
            'link' => $this->string(255),
            'link_title' => $this->string(255),
            'service_id' => $this->integer(),
            'public' => $this->boolean(),
            'weight' => $this->integer(),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Баннер', 'model' => 'ServiceLink', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('service_link');
    }
}
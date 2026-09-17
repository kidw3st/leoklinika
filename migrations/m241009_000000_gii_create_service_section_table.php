<?php
use yii\db\Migration;
class m241009_000000_gii_create_service_section_table extends Migration
{
    public function up()
    {
        $this->createTable('service_section', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'handle' => $this->string(255),
            'public' => $this->boolean(),
            'weight' => $this->integer(),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Раздел', 'model' => 'ServiceSection', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('service_section');
    }
}
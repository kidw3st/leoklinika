<?php
use yii\db\Migration;
class m241023_000000_gii_create_service_tag_table extends Migration
{
    public function up()
    {
        $this->createTable('service_tag', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'public' => $this->boolean(),
            'weight' => $this->integer(),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Тег', 'model' => 'ServiceTag', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('service_tag');
    }
}
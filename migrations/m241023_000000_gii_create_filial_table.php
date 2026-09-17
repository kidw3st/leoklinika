<?php
use yii\db\Migration;
class m241023_000000_gii_create_filial_table extends Migration
{
    public function up()
    {
        $this->createTable('filial', [
            'id' => $this->primaryKey(),
            'city' => $this->string(255),
            'address' => $this->string(255),
            'phones' => $this->string(2000),
            'times' => $this->string(1000),
            'public' => $this->boolean(),
            'weight' => $this->integer(),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Филиал', 'model' => 'Filial', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('filial');
    }
}
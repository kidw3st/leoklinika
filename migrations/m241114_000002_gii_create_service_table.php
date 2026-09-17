<?php
use yii\db\Migration;
class m241114_000002_gii_create_service_table extends Migration
{
    public function up()
    {
        $this->createTable('service2filial', [
            'service_id' => $this->integer(),
            'filial_id' => $this->integer(),
        ]);
    }

    public function down()
    {
        $this->dropTable('service2filial');
    }
}
<?php
use yii\db\Migration;
class m241023_000002_gii_create_service_table extends Migration
{
    public function up()
    {
        $this->createTable('service2tag', [
            'service_id' => $this->integer(),
            'tag_id' => $this->integer(),
        ]);
    }

    public function down()
    {
        $this->dropTable('service2tag');
    }
}
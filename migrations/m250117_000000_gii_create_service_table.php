<?php
use yii\db\Migration;
class m250117_000000_gii_create_service_table extends Migration
{
    public function up()
    {
        $this->addColumn('service', 'created_at', $this->dateTime());
        $this->addColumn('service', 'updated_at', $this->dateTime());
    }

    public function down()
    {
        $this->dropColumn('service', 'created_at');
        $this->dropColumn('service', 'updated_at');
    }
}
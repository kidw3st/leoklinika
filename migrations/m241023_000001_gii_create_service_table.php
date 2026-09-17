<?php
use yii\db\Migration;
class m241023_000001_gii_create_service_table extends Migration
{
    public function up()
    {
        $this->dropColumn('service', 'weight');
    }

    public function down()
    {
        $this->addColumn('service', 'weight', $this->integer());
    }
}
<?php
use yii\db\Migration;
class m241122_000002_gii_create_service_table extends Migration
{
    public function up()
    {
        $this->dropColumn('service', 'show_consult');
    }

    public function down()
    {
        $this->addColumn('service', 'show_consult', $this->boolean());
    }
}
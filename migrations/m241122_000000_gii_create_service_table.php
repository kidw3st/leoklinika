<?php
use yii\db\Migration;
class m241122_000000_gii_create_service_table extends Migration
{
    public function up()
    {
        $this->addColumn('service', 'show_consult', $this->string(255));
    }

    public function down()
    {
        $this->dropColumn('service', 'show_consult');
    }
}
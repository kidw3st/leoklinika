<?php
use yii\db\Migration;
class m241204_000000_gii_create_service_price_table extends Migration
{
    public function up()
    {
        $this->addColumn('service_price', 'is_consult', $this->boolean());
    }

    public function down()
    {
        $this->dropColumn('service_price', 'is_consult');
    }
}
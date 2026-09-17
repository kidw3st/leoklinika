<?php
use yii\db\Migration;
class m241228_000000_gii_create_service_table extends Migration
{
    public function up()
    {
        $this->addColumn('service', 'lvl', $this->float());
    }

    public function down()
    {
        $this->dropColumn('service', 'lvl');
    }
}
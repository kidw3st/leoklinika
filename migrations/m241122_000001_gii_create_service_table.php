<?php
use yii\db\Migration;
class m241122_000001_gii_create_service_table extends Migration
{
    public function up()
    {
        $this->alterColumn('service', 'show_consult', $this->boolean());
    }

    public function down()
    {
        $this->alterColumn('service', 'show_consult', $this->string(255));
    }
}
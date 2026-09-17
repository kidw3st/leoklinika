<?php
use yii\db\Migration;
class m241219_000001_gii_create_request_appointment_table extends Migration
{
    public function up()
    {
        $this->addColumn('request_appointment', 'page_id', $this->integer());
    }

    public function down()
    {
        $this->dropColumn('request_appointment', 'page_id');
    }
}
<?php
use yii\db\Migration;
class m241122_000001_gii_create_request_appointment_table extends Migration
{
    public function up()
    {
        $this->addColumn('request_appointment', 'member_id', $this->integer());
    }

    public function down()
    {
        $this->dropColumn('request_appointment', 'member_id');
    }
}
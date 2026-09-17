<?php
use yii\db\Migration;
class m241219_000000_gii_create_request_call_doctor_table extends Migration
{
    public function up()
    {
        $this->addColumn('request_call_doctor', 'page_id', $this->integer());
    }

    public function down()
    {
        $this->dropColumn('request_call_doctor', 'page_id');
    }
}
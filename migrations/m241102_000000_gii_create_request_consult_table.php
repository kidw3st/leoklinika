<?php
use yii\db\Migration;
class m241102_000000_gii_create_request_consult_table extends Migration
{
    public function up()
    {
        $this->addColumn('request_consult', 'name', $this->string(255));
        $this->dropColumn('request_consult', 'member_id');
    }

    public function down()
    {
        $this->addColumn('request_consult', 'member_id', $this->integer());
        $this->dropColumn('request_consult', 'name');
    }
}
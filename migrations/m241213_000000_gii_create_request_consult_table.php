<?php
use yii\db\Migration;
class m241213_000000_gii_create_request_consult_table extends Migration
{
    public function up()
    {
        $this->addColumn('request_consult', 'action_id', $this->integer());
    }

    public function down()
    {
        $this->dropColumn('request_consult', 'action_id');
    }
}
<?php
use yii\db\Migration;
class m241219_000000_gii_create_request_consult_table extends Migration
{
    public function up()
    {
        $this->addColumn('request_consult', 'page_id', $this->integer());
    }

    public function down()
    {
        $this->dropColumn('request_consult', 'page_id');
    }
}
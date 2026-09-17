<?php
use yii\db\Migration;
class m241204_000000_gii_create_faq_table extends Migration
{
    public function up()
    {
        $this->addColumn('faq', 'service_id', $this->integer());
    }

    public function down()
    {
        $this->dropColumn('faq', 'service_id');
    }
}
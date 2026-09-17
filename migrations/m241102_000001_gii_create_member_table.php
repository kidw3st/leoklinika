<?php
use yii\db\Migration;
class m241102_000001_gii_create_member_table extends Migration
{
    public function up()
    {
        $this->addColumn('member', 'is_lead', $this->boolean());
        $this->dropColumn('member', 'lead');
    }

    public function down()
    {
        $this->addColumn('member', 'lead', $this->boolean());
        $this->dropColumn('member', 'is_lead');
    }
}
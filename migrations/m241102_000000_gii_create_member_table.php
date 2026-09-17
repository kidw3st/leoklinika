<?php
use yii\db\Migration;
class m241102_000000_gii_create_member_table extends Migration
{
    public function up()
    {
        $this->addColumn('member', 'lead', $this->boolean());
    }

    public function down()
    {
        $this->dropColumn('member', 'lead');
    }
}
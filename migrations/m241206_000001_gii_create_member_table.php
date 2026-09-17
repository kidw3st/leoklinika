<?php
use yii\db\Migration;
class m241206_000001_gii_create_member_table extends Migration
{
    public function up()
    {
        $this->addColumn('member', 'direct_type_adult', $this->boolean());
        $this->addColumn('member', 'direct_type_child', $this->boolean());
    }

    public function down()
    {
        $this->dropColumn('member', 'direct_type_adult');
        $this->dropColumn('member', 'direct_type_child');
    }
}
<?php
use yii\db\Migration;
class m250117_000000_gii_create_member_table extends Migration
{
    public function up()
    {
        $this->addColumn('member', 'created_at', $this->dateTime());
        $this->addColumn('member', 'updated_at', $this->dateTime());
    }

    public function down()
    {
        $this->dropColumn('member', 'created_at');
        $this->dropColumn('member', 'updated_at');
    }
}
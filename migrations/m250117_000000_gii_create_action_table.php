<?php
use yii\db\Migration;
class m250117_000000_gii_create_action_table extends Migration
{
    public function up()
    {
        $this->addColumn('action', 'created_at', $this->dateTime());
        $this->addColumn('action', 'updated_at', $this->dateTime());
    }

    public function down()
    {
        $this->dropColumn('action', 'created_at');
        $this->dropColumn('action', 'updated_at');
    }
}
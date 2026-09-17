<?php
use yii\db\Migration;
class m241213_000001_gii_create_action_table extends Migration
{
    public function up()
    {
        $this->addColumn('action', 'service_id', $this->integer());
    }

    public function down()
    {
        $this->dropColumn('action', 'service_id');
    }
}
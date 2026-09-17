<?php
use yii\db\Migration;
class m241213_000003_gii_create_action_table extends Migration
{
    public function up()
    {
        $this->addColumn('action', 'profit', $this->string(255));
        $this->addColumn('action', 'duration', $this->string(255));
    }

    public function down()
    {
        $this->dropColumn('action', 'profit');
        $this->dropColumn('action', 'duration');
    }
}
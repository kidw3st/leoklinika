<?php
use yii\db\Migration;
class m241228_000000_gii_create_action_table extends Migration
{
    public function up()
    {
        $this->addColumn('action', 'title2', $this->string(50));
    }

    public function down()
    {
        $this->dropColumn('action', 'title2');
    }
}
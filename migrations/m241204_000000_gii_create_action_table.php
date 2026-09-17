<?php
use yii\db\Migration;
class m241204_000000_gii_create_action_table extends Migration
{
    public function up()
    {
        $this->createTable('action2price', [
            'action_id' => $this->integer(),
            'price_id' => $this->integer(),
        ]);
    }

    public function down()
    {
        $this->dropTable('action2price');
    }
}
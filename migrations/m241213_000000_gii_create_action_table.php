<?php
use yii\db\Migration;
class m241213_000000_gii_create_action_table extends Migration
{
    public function up()
    {
        $this->createTable('action2tag', [
            'action_id' => $this->integer(),
            'tag_id' => $this->integer(),
        ]);
    }

    public function down()
    {
        $this->dropTable('action2tag');
    }
}
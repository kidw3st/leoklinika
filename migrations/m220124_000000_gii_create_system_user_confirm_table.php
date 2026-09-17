<?php
use yii\db\Migration;
class m220124_000000_gii_create_system_user_confirm_table extends Migration
{
    public function up()
    {
        $this->createTable('system_user_confirm', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'type' => $this->string(50),
            'code' => $this->string(8),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);
    }

    public function down()
    {
        $this->dropTable('system_user_confirm');
    }
}
<?php
use yii\db\Migration;
class m220124_000000_gii_create_system_user_social_table extends Migration
{
    public function up()
    {
        $this->createTable('system_user_social', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'soc_id' => $this->string(50),
            'soc_name' => $this->string(25),
            'data' => $this->text(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);
    }

    public function down()
    {
        $this->dropTable('system_user_social');
    }
}
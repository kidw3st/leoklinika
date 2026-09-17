<?php
use yii\db\Migration;
class m220124_000000_gii_create_system_user_group_model_table extends Migration
{
    public function up()
    {
        $this->createTable('system_user_group_model', [
            'id' => $this->primaryKey(),
            'model' => $this->string(70),
            'user_group_id' => $this->integer(),
        ]);
    }

    public function down()
    {
        $this->dropTable('system_user_group_model');
    }
}
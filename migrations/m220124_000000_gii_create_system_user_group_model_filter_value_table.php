<?php
use yii\db\Migration;
class m220124_000000_gii_create_system_user_group_model_filter_value_table extends Migration
{
    public function up()
    {
        $this->createTable('system_user_group_model_filter_value', [
            'id' => $this->primaryKey(),
            'value_id' => $this->integer(),
            'user_group_model_filter_id' => $this->integer(),
        ]);
    }

    public function down()
    {
        $this->dropTable('system_user_group_model_filter_value');
    }
}
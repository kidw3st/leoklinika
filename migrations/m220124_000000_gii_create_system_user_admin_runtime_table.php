<?php
use yii\db\Migration;
class m220124_000000_gii_create_system_user_admin_runtime_table extends Migration
{
    public function up()
    {
        $this->createTable('system_user_admin_runtime', [
            'id' => $this->primaryKey(),
            'model' => $this->string(255),
            'user_id' => $this->integer(),
            'params' => $this->text(),
        ]);
    }

    public function down()
    {
        $this->dropTable('system_user_admin_runtime');
    }
}
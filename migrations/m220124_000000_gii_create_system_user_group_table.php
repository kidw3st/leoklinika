<?php
use yii\db\Migration;
class m220124_000000_gii_create_system_user_group_table extends Migration
{
    public function up()
    {
        $this->createTable('system_user_group', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Группа пользователя', 'model' => 'SystemUserGroup', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('system_user_group');
    }
}
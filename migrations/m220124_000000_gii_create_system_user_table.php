<?php
use yii\db\Migration;
class m220124_000000_gii_create_system_user_table extends Migration
{
    public function up()
    {
        $this->createTable('system_user', [
            'id' => $this->primaryKey(),
            'login_username' => $this->string(255),
            'login_email' => $this->string(80),
            'login_phone' => $this->bigInteger(),
            'password' => $this->string(32),
            'auth_key' => $this->string(32),
            'name' => $this->string(255),
            'surname' => $this->string(255),
            'second_name' => $this->string(255),
            'access_token' => $this->string(32),
            'image' => $this->string(255),
            'status' => $this->float(),
            'cookieArray' => $this->text(),
            'admin' => $this->boolean(),
            'group_id' => $this->integer(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Пользователь', 'model' => 'SystemUser', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('system_user');
    }
}
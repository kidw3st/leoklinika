<?php
use yii\db\Migration;
class m220124_000000_gii_create_system_menu_type_table extends Migration
{
    public function up()
    {
        $this->createTable('system_menu_type', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'handle' => $this->string(255),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Тип меню', 'model' => 'SystemMenuType', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('system_menu_type');
    }
}
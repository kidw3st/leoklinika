<?php
use yii\db\Migration;
class m220124_000000_gii_create_system_menu_table extends Migration
{
    public function up()
    {
        $this->createTable('system_menu', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'url' => $this->string(255),
            'lft' => $this->integer(),
            'rgt' => $this->integer(),
            'depth' => $this->integer(),
            'public' => $this->boolean(),
        ]);
        $this->insert('system_menu', [
            'title' => 'Корень',
            'public' => 1,
            'lft' => 1,
            'rgt' => 2,
            'depth' => 0,
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Меню', 'model' => 'SystemMenu', 'public' => 1]))->controllerSave();
        $this->createTable('system_menu2type', [
            'menu_id' => $this->integer(),
            'type_id' => $this->integer(),
        ]);
    }

    public function down()
    {
        $this->dropTable('system_menu');
        $this->dropTable('system_menu2type');
    }
}
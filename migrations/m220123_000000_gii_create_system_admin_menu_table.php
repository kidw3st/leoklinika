<?php
use yii\db\Migration;
class m220123_000000_gii_create_system_admin_menu_table extends Migration
{
    public function up()
    {
        $this->createTable('system_admin_menu', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'url' => $this->string(255),
            'model' => $this->string(255),
            'lft' => $this->integer(),
            'rgt' => $this->integer(),
            'depth' => $this->integer(),
            'public' => $this->boolean(),
        ]);
        $this->insert('system_admin_menu', [
            'title' => 'Корень',
            'public' => 1,
            'lft' => 1,
            'rgt' => 2,
            'depth' => 0,
        ]);
    }

    public function down()
    {
        $this->dropTable('system_admin_menu');
    }
}
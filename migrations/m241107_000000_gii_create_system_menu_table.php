<?php
use yii\db\Migration;
class m241107_000000_gii_create_system_menu_table extends Migration
{
    public function up()
    {
        $this->addColumn('system_menu', 'is_service', $this->boolean());
        $this->addColumn('system_menu', 'title_2', $this->string(255));
        $this->addColumn('system_menu', 'title_3', $this->string(255));
    }

    public function down()
    {
        $this->dropColumn('system_menu', 'is_service');
        $this->dropColumn('system_menu', 'title_2');
        $this->dropColumn('system_menu', 'title_3');
    }
}
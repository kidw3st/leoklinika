<?php
use app\models\SystemAdminMenu;
use yii\db\Migration;
class m250117_000000_gii_settings_members extends Migration
{
    public function up()
    {
        $root = SystemAdminMenu::find()->orderBy('lft ASC')->one();

        $menu = new SystemAdminMenu(['model' => 'SystemSettingsMembers']);
        $menu->title = 'Настройки';
        $menu->public = 1;
        $menu->appendTo($root);
    }

    public function down()
    {
        $menu = SystemAdminMenu::find()->where(['model' => 'SystemSettingsMembers'])->one();
        $menu->delete();
    }
}
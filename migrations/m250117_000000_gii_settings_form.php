<?php
use app\models\SystemAdminMenu;
use yii\db\Migration;
class m250117_000000_gii_settings_form extends Migration
{
    public function up()
    {
        $root = SystemAdminMenu::find()->orderBy('lft ASC')->one();

        $menu = new SystemAdminMenu(['model' => 'SystemSettingsForm']);
        $menu->title = 'Настройки';
        $menu->public = 1;
        $menu->appendTo($root);
    }

    public function down()
    {
        $menu = SystemAdminMenu::find()->where(['model' => 'SystemSettingsForm'])->one();
        $menu->delete();
    }
}
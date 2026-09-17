<?php
use yii\db\Migration;
class m220124_000000_gii_create_system_settings_table extends Migration
{
    public function up()
    {
        $this->createTable('system_settings', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'module' => $this->string(255),
            'code' => $this->string(255),
            'type' => $this->float(),
            'value' => $this->text(),
            'model_class' => $this->string(50),
            'value_model' => $this->float(),
            'value_file' => $this->string(255),
            'options' => $this->text(),
            'weight' => $this->integer(),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Настройки', 'model' => 'SystemSettings', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('system_settings');
    }
}
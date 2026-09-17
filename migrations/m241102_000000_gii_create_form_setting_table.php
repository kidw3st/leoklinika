<?php
use yii\db\Migration;
class m241102_000000_gii_create_form_setting_table extends Migration
{
    public function up()
    {
        $this->createTable('form_setting', [
            'id' => $this->primaryKey(),
            'form_type' => $this->string(50),
            'title' => $this->string(255),
            'description' => $this->text(),
            'image' => $this->string(255),
            'link_title' => $this->string(255),
            'video_id' => $this->integer(),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Настройка формы', 'model' => 'FormSetting', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('form_setting');
    }
}
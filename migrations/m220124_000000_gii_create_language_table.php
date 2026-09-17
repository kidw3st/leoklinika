<?php
use yii\db\Migration;
class m220124_000000_gii_create_language_table extends Migration
{
    public function up()
    {
        $this->createTable('language', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'handle' => $this->string(255),
            'short_title' => $this->string(255),
            'is_main' => $this->boolean(),
            'i18n_code' => $this->string(255),
            'weight' => $this->integer(),
            'public' => $this->boolean(),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Язык', 'model' => 'Language', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('language');
    }
}
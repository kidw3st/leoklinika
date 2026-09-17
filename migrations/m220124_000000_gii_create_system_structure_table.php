<?php
use yii\db\Migration;
class m220124_000000_gii_create_system_structure_table extends Migration
{
    public function up()
    {
        $this->createTable('system_structure', [
            'id' => $this->primaryKey(),
            'controller' => $this->string(255),
            'url' => $this->string(255),
            'h1_title' => $this->string(255),
            'weight' => $this->integer(),
            'public' => $this->boolean(),
            'seo_title' => $this->string(255),
            'seo_description' => $this->string(500),
            'seo_keywords' => $this->string(255),
            'og_title' => $this->string(255),
            'og_description' => $this->string(500),
            'og_image' => $this->string(255),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Структура', 'model' => 'SystemStructure', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('system_structure');
    }
}
<?php
use yii\db\Migration;
class m230201_000000_gii_create_page_meta_table extends Migration
{
    public function up()
    {
        $this->createTable('page_meta', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'handle' => $this->string(255),
            'seo_title' => $this->string(255),
            'seo_description' => $this->string(500),
            'seo_keywords' => $this->string(255),
            'og_title' => $this->string(255),
            'og_description' => $this->string(500),
            'og_image' => $this->string(255),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Страница (Мета)', 'model' => 'PageMeta', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('page_meta');
    }
}
<?php
use yii\db\Migration;
class m241023_000000_gii_create_article_table extends Migration
{
    public function up()
    {
        $this->createTable('article', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'handle' => $this->string(255),
            'image' => $this->string(255),
            'description' => $this->string(1000),
            'public' => $this->boolean(),
            'seo_title' => $this->string(255),
            'seo_description' => $this->string(500),
            'seo_keywords' => $this->string(255),
            'og_title' => $this->string(255),
            'og_description' => $this->string(500),
            'og_image' => $this->string(255),
            'weight' => $this->integer(),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Статья', 'model' => 'Article', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('article');
    }
}
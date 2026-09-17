<?php
use yii\db\Migration;
class m241015_000000_gii_create_request_review_table extends Migration
{
    public function up()
    {
        $this->createTable('request_review', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255),
            'text' => $this->string(2000),
            'rating' => $this->integer(),
            'source' => $this->string(255),
            'theme' => $this->string(255),
            'date' => $this->dateTime(),
            'seo_title' => $this->string(255),
            'seo_description' => $this->string(500),
            'seo_keywords' => $this->string(255),
            'og_title' => $this->string(255),
            'og_description' => $this->string(500),
            'og_image' => $this->string(255),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Отзыв', 'model' => 'RequestReview', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('request_review');
    }
}
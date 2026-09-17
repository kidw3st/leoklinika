<?php
use yii\db\Migration;
class m241204_000000_gii_create_request_action_table extends Migration
{
    public function up()
    {
        $this->createTable('request_action', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255),
            'phone' => $this->string(255),
            'block_id' => $this->integer(),
            'seo_title' => $this->string(255),
            'seo_description' => $this->string(500),
            'seo_keywords' => $this->string(255),
            'og_title' => $this->string(255),
            'og_description' => $this->string(500),
            'og_image' => $this->string(255),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Заявка', 'model' => 'RequestAction', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('request_action');
    }
}
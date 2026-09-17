<?php
use yii\db\Migration;
class m241023_000000_gii_create_page_block_faq_table extends Migration
{
    public function up()
    {
        $this->createTable('page_block_faq', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'text' => $this->string(500),
            'page_block_id' => $this->integer(),
            'public' => $this->boolean(),
            'weight' => $this->integer(),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Вопрос', 'model' => 'PageBlockFaq', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('page_block_faq');
    }
}
<?php
use yii\db\Migration;
class m241119_000000_gii_create_faq_table extends Migration
{
    public function up()
    {
        $this->createTable('faq', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'text' => $this->text(),
            'page_block_id' => $this->integer(),
            'public' => $this->boolean(),
            'weight' => $this->integer(),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Вопрос', 'model' => 'Faq', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('faq');
    }
}
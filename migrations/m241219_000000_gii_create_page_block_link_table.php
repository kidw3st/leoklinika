<?php
use yii\db\Migration;
class m241219_000000_gii_create_page_block_link_table extends Migration
{
    public function up()
    {
        $this->createTable('page_block_link', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'link' => $this->string(255),
            'page_block_id' => $this->integer(),
            'public' => $this->boolean(),
            'weight' => $this->integer(),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Ссылка', 'model' => 'PageBlockLink', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('page_block_link');
    }
}
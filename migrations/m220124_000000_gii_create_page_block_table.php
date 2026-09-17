<?php
use yii\db\Migration;
class m220124_000000_gii_create_page_block_table extends Migration
{
    public function up()
    {
        $this->createTable('page_block', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'block_type' => $this->string(50),
            'text' => $this->text(),
            'page_id' => $this->integer(),
            'weight' => $this->integer(),
            'public' => $this->boolean(),
        ]);
    }

    public function down()
    {
        $this->dropTable('page_block');
    }
}
<?php
use yii\db\Migration;
class m250127_000002_gii_create_page_block_slide_table extends Migration
{
    public function up()
    {
        $this->alterColumn('page_block_slide', 'text', $this->string(200));
    }

    public function down()
    {
        $this->alterColumn('page_block_slide', 'text', $this->string(150));
    }
}
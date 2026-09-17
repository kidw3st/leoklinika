<?php
use yii\db\Migration;
class m241108_000000_gii_create_page_block_slide_table extends Migration
{
    public function up()
    {
        $this->alterColumn('page_block_slide', 'title', $this->string(70));
        $this->alterColumn('page_block_slide', 'text', $this->string(120));
    }

    public function down()
    {
        $this->alterColumn('page_block_slide', 'title', $this->string(255));
        $this->alterColumn('page_block_slide', 'text', $this->string(500));
    }
}
<?php
use yii\db\Migration;
class m250127_000000_gii_create_page_block_slide_table extends Migration
{
    public function up()
    {
        $this->alterColumn('page_block_slide', 'title', $this->string(100));
    }

    public function down()
    {
        $this->alterColumn('page_block_slide', 'title', $this->string(70));
    }
}
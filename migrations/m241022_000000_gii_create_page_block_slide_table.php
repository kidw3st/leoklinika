<?php
use yii\db\Migration;
class m241022_000000_gii_create_page_block_slide_table extends Migration
{
    public function up()
    {
        $this->addColumn('page_block_slide', 'text', $this->string(500));
        $this->addColumn('page_block_slide', 'link', $this->string(255));
        $this->addColumn('page_block_slide', 'link_title', $this->string(255));
    }

    public function down()
    {
        $this->dropColumn('page_block_slide', 'text');
        $this->dropColumn('page_block_slide', 'link');
        $this->dropColumn('page_block_slide', 'link_title');
    }
}
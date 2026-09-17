<?php
use yii\db\Migration;
class m241023_000001_gii_create_page_block_faq_table extends Migration
{
    public function up()
    {
        $this->alterColumn('page_block_faq', 'text', $this->text());
    }

    public function down()
    {
        $this->alterColumn('page_block_faq', 'text', $this->string(500));
    }
}
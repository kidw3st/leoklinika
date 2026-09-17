<?php
use yii\db\Migration;
class m241219_000001_gii_create_page_block_table extends Migration
{
    public function up()
    {
        $this->addColumn('page_block', 'show_title', $this->boolean());
    }

    public function down()
    {
        $this->dropColumn('page_block', 'show_title');
    }
}
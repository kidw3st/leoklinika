<?php
use yii\db\Migration;
class m241009_000002_gii_create_page_block_table extends Migration
{
    public function up()
    {
        $this->addColumn('page_block', 'link', $this->string(255));
        $this->addColumn('page_block', 'link_title', $this->string(255));
    }

    public function down()
    {
        $this->dropColumn('page_block', 'link');
        $this->dropColumn('page_block', 'link_title');
    }
}
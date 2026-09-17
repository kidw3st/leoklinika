<?php
use yii\db\Migration;
class m241023_000000_gii_create_page_block_table extends Migration
{
    public function up()
    {
        $this->addColumn('page_block', 'only_popular', $this->boolean());
    }

    public function down()
    {
        $this->dropColumn('page_block', 'only_popular');
    }
}
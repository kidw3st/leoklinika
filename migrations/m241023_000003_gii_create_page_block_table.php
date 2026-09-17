<?php
use yii\db\Migration;
class m241023_000003_gii_create_page_block_table extends Migration
{
    public function up()
    {
        $this->addColumn('page_block', 'title_2', $this->string(255));
    }

    public function down()
    {
        $this->dropColumn('page_block', 'title_2');
    }
}
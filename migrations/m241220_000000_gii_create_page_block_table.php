<?php
use yii\db\Migration;
class m241220_000000_gii_create_page_block_table extends Migration
{
    public function up()
    {
        $this->addColumn('page_block', 'success_text', $this->string(255));
    }

    public function down()
    {
        $this->dropColumn('page_block', 'success_text');
    }
}
<?php
use yii\db\Migration;
class m241009_000000_gii_create_page_block_table extends Migration
{
    public function up()
    {
        $this->addColumn('page_block', 'form_type', $this->string(50));
    }

    public function down()
    {
        $this->dropColumn('page_block', 'form_type');
    }
}
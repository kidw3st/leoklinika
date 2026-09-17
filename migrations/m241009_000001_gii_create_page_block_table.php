<?php
use yii\db\Migration;
class m241009_000001_gii_create_page_block_table extends Migration
{
    public function up()
    {
        $this->addColumn('page_block', 'image', $this->string(255));
    }

    public function down()
    {
        $this->dropColumn('page_block', 'image');
    }
}
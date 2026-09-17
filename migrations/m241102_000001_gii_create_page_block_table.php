<?php
use yii\db\Migration;
class m241102_000001_gii_create_page_block_table extends Migration
{
    public function up()
    {
        $this->addColumn('page_block', 'video', $this->string(255));
    }

    public function down()
    {
        $this->dropColumn('page_block', 'video');
    }
}
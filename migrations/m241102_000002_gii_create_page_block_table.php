<?php
use yii\db\Migration;
class m241102_000002_gii_create_page_block_table extends Migration
{
    public function up()
    {
        $this->addColumn('page_block', 'video_id', $this->integer());
        $this->dropColumn('page_block', 'video');
    }

    public function down()
    {
        $this->addColumn('page_block', 'video', $this->string(255));
        $this->dropColumn('page_block', 'video_id');
    }
}
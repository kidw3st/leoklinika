<?php
use yii\db\Migration;
class m241219_000000_gii_create_page_block_table extends Migration
{
    public function up()
    {
        $this->addColumn('page_block', 'video_title', $this->string(255));
    }

    public function down()
    {
        $this->dropColumn('page_block', 'video_title');
    }
}
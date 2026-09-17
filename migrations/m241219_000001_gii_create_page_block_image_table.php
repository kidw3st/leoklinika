<?php
use yii\db\Migration;
class m241219_000001_gii_create_page_block_image_table extends Migration
{
    public function up()
    {
        $this->addColumn('page_block_image', 'text', $this->string(255));
    }

    public function down()
    {
        $this->dropColumn('page_block_image', 'text');
    }
}
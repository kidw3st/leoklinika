<?php
use yii\db\Migration;
class m241023_000001_gii_create_page_block_table extends Migration
{
    public function up()
    {
        $this->addColumn('page_block', 'description', $this->text());
        $this->addColumn('page_block', 'image_mobile', $this->string(255));
    }

    public function down()
    {
        $this->dropColumn('page_block', 'description');
        $this->dropColumn('page_block', 'image_mobile');
    }
}
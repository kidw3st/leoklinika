<?php
use yii\db\Migration;
class m241102_000000_gii_create_page_block_table extends Migration
{
    public function up()
    {
        $this->addColumn('page_block', 'only_lead', $this->boolean());
    }

    public function down()
    {
        $this->dropColumn('page_block', 'only_lead');
    }
}
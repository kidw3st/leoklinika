<?php
use yii\db\Migration;
class m251007_000001_gii_create_service_block_table extends Migration
{
    public function up()
    {
        $this->addColumn('service_block', 'link', $this->string(255));
        $this->addColumn('service_block', 'link_title', $this->string(255));
    }

    public function down()
    {
        $this->dropColumn('service_block', 'link');
        $this->dropColumn('service_block', 'link_title');
    }
}
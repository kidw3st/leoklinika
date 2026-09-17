<?php
use yii\db\Migration;
class m251007_000002_gii_create_service_block_table extends Migration
{
    public function up()
    {
        $this->addColumn('service_block', 'text', $this->text());
    }

    public function down()
    {
        $this->dropColumn('service_block', 'text');
    }
}
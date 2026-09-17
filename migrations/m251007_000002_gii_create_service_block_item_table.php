<?php
use yii\db\Migration;
class m251007_000002_gii_create_service_block_item_table extends Migration
{
    public function up()
    {
        $this->addColumn('service_block_item', 'description', $this->text());
    }

    public function down()
    {
        $this->dropColumn('service_block_item', 'description');
    }
}
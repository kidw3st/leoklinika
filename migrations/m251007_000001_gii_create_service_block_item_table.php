<?php
use yii\db\Migration;
class m251007_000001_gii_create_service_block_item_table extends Migration
{
    public function up()
    {
        $this->addColumn('service_block_item', 'title_modal', $this->string(255));
    }

    public function down()
    {
        $this->dropColumn('service_block_item', 'title_modal');
    }
}
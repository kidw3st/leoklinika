<?php
use yii\db\Migration;
class m251007_000003_gii_create_service_block_item_table extends Migration
{
    public function up()
    {
        $this->addColumn('service_block_item', 'image', $this->string(255));
        $this->addColumn('service_block_item', 'image_alt', $this->string(255));
    }

    public function down()
    {
        $this->dropColumn('service_block_item', 'image');
        $this->dropColumn('service_block_item', 'image_alt');
    }
}
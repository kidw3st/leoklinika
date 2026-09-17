<?php
use yii\db\Migration;
class m251007_000004_gii_create_service_block_table extends Migration
{
    public function up()
    {
        $this->addColumn('service_block', 'image', $this->string(255));
        $this->addColumn('service_block', 'image_alt', $this->string(255));
    }

    public function down()
    {
        $this->dropColumn('service_block', 'image');
        $this->dropColumn('service_block', 'image_alt');
    }
}
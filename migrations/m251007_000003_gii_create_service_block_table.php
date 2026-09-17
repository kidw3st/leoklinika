<?php
use yii\db\Migration;
class m251007_000003_gii_create_service_block_table extends Migration
{
    public function up()
    {
        $this->addColumn('service_block', 'block_class', $this->string(50));
    }

    public function down()
    {
        $this->dropColumn('service_block', 'block_class');
    }
}
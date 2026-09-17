<?php
use yii\db\Migration;
class m251007_000000_gii_create_service_table extends Migration
{
    public function up()
    {
        $this->addColumn('service', 'text_title', $this->string(255));
    }

    public function down()
    {
        $this->dropColumn('service', 'text_title');
    }
}
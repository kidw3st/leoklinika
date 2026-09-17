<?php
use yii\db\Migration;
class m241120_000000_gii_create_service_table extends Migration
{
    public function up()
    {
        $this->addColumn('service', 'image_3', $this->string(255));
    }

    public function down()
    {
        $this->dropColumn('service', 'image_3');
    }
}
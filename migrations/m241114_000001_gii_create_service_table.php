<?php
use yii\db\Migration;
class m241114_000001_gii_create_service_table extends Migration
{
    public function up()
    {
        $this->addColumn('service', 'image_2', $this->string(255));
    }

    public function down()
    {
        $this->dropColumn('service', 'image_2');
    }
}
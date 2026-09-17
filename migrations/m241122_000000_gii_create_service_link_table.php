<?php
use yii\db\Migration;
class m241122_000000_gii_create_service_link_table extends Migration
{
    public function up()
    {
        $this->addColumn('service_link', 'background_color', $this->string(50));
    }

    public function down()
    {
        $this->dropColumn('service_link', 'background_color');
    }
}
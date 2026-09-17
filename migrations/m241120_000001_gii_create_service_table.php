<?php
use yii\db\Migration;
class m241120_000001_gii_create_service_table extends Migration
{
    public function up()
    {
        $this->addColumn('service', 'members_title', $this->string(255));
    }

    public function down()
    {
        $this->dropColumn('service', 'members_title');
    }
}
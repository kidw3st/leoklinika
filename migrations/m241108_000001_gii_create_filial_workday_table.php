<?php
use yii\db\Migration;
class m241108_000001_gii_create_filial_workday_table extends Migration
{
    public function up()
    {
        $this->addColumn('filial_workday', 'filial_id', $this->integer());
    }

    public function down()
    {
        $this->dropColumn('filial_workday', 'filial_id');
    }
}
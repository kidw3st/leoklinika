<?php
use yii\db\Migration;
class m241023_000001_gii_create_filial_table extends Migration
{
    public function up()
    {
        $this->addColumn('filial', 'is_default', $this->boolean());
    }

    public function down()
    {
        $this->dropColumn('filial', 'is_default');
    }
}
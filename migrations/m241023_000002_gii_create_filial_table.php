<?php
use yii\db\Migration;
class m241023_000002_gii_create_filial_table extends Migration
{
    public function up()
    {
        $this->alterColumn('filial', 'times', $this->text());
    }

    public function down()
    {
        $this->alterColumn('filial', 'times', $this->string(1000));
    }
}
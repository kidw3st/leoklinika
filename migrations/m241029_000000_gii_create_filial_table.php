<?php
use yii\db\Migration;
class m241029_000000_gii_create_filial_table extends Migration
{
    public function up()
    {
        $this->addColumn('filial', 'title', $this->string(255));
        $this->addColumn('filial', 'emails', $this->text());
        $this->addColumn('filial', 'coord_x', $this->double());
        $this->addColumn('filial', 'coord_y', $this->string(255));
    }

    public function down()
    {
        $this->dropColumn('filial', 'title');
        $this->dropColumn('filial', 'emails');
        $this->dropColumn('filial', 'coord_x');
        $this->dropColumn('filial', 'coord_y');
    }
}
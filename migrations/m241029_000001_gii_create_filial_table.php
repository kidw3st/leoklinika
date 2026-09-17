<?php
use yii\db\Migration;
class m241029_000001_gii_create_filial_table extends Migration
{
    public function up()
    {
        $this->alterColumn('filial', 'coord_y', $this->double());
    }

    public function down()
    {
        $this->alterColumn('filial', 'coord_y', $this->string(255));
    }
}
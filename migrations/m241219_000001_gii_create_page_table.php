<?php
use yii\db\Migration;
class m241219_000001_gii_create_page_table extends Migration
{
    public function up()
    {
        $this->addColumn('page', 'template', $this->string(50));
    }

    public function down()
    {
        $this->dropColumn('page', 'template');
    }
}
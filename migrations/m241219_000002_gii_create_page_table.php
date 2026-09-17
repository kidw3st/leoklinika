<?php
use yii\db\Migration;
class m241219_000002_gii_create_page_table extends Migration
{
    public function up()
    {
        $this->addColumn('page', 'button_text', $this->string(255));
        $this->addColumn('page', 'form', $this->string(50));
    }

    public function down()
    {
        $this->dropColumn('page', 'button_text');
        $this->dropColumn('page', 'form');
    }
}
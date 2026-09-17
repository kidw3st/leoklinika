<?php
use yii\db\Migration;
class m241219_000000_gii_create_page_table extends Migration
{
    public function up()
    {
        $this->addColumn('page', 'show_header', $this->boolean());
    }

    public function down()
    {
        $this->dropColumn('page', 'show_header');
    }
}
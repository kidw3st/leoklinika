<?php
use yii\db\Migration;
class m241224_000000_gii_create_form_setting_table extends Migration
{
    public function up()
    {
        $this->addColumn('form_setting', 'form_name', $this->string(255));
        $this->alterColumn('form_setting', 'form_type', $this->string(255));
    }

    public function down()
    {
        $this->alterColumn('form_setting', 'form_type', $this->string(50));
        $this->dropColumn('form_setting', 'form_name');
    }
}
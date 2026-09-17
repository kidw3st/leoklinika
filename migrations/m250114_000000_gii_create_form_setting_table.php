<?php
use yii\db\Migration;
class m250114_000000_gii_create_form_setting_table extends Migration
{
    public function up()
    {
        $this->addColumn('form_setting', 'success_text', $this->string(255));
    }

    public function down()
    {
        $this->dropColumn('form_setting', 'success_text');
    }
}
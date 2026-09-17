<?php
use yii\db\Migration;
class m241122_000004_gii_create_service_table extends Migration
{
    public function up()
    {
        $this->alterColumn('service', 'intro_text', $this->text());
    }

    public function down()
    {
        $this->alterColumn('service', 'intro_text', $this->string(255));
    }
}
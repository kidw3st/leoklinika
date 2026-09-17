<?php
use yii\db\Migration;
class m241224_000001_gii_create_request_vacancy_table extends Migration
{
    public function up()
    {
        $this->addColumn('request_vacancy', 'file', $this->string(255));
    }

    public function down()
    {
        $this->dropColumn('request_vacancy', 'file');
    }
}
<?php
use yii\db\Migration;
class m241224_000001_gii_create_request_vacancy_file_table extends Migration
{
    public function up()
    {
        $this->addColumn('request_vacancy_file', 'request_vacancy_id', $this->integer());
    }

    public function down()
    {
        $this->dropColumn('request_vacancy_file', 'request_vacancy_id');
    }
}
<?php
use yii\db\Migration;
class m241224_000000_gii_create_request_vacancy_file_table extends Migration
{
    public function up()
    {
        $this->createTable('request_vacancy_file', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'file' => $this->string(255),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Файл', 'model' => 'RequestVacancyFile', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('request_vacancy_file');
    }
}
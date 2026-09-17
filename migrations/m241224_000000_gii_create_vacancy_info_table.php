<?php
use yii\db\Migration;
class m241224_000000_gii_create_vacancy_info_table extends Migration
{
    public function up()
    {
        $this->createTable('vacancy_info', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'text' => $this->text(),
            'vacancy_id' => $this->integer(),
            'public' => $this->boolean(),
            'weight' => $this->integer(),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Информация', 'model' => 'VacancyInfo', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('vacancy_info');
    }
}
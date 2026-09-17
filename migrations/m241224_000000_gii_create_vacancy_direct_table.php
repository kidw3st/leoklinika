<?php
use yii\db\Migration;
class m241224_000000_gii_create_vacancy_direct_table extends Migration
{
    public function up()
    {
        $this->createTable('vacancy_direct', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'public' => $this->boolean(),
            'weight' => $this->integer(),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Направление', 'model' => 'VacancyDirect', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('vacancy_direct');
    }
}
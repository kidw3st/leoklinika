<?php
use yii\db\Migration;
class m241224_000000_gii_create_vacancy_table extends Migration
{
    public function up()
    {
        $this->createTable('vacancy', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'direct_id' => $this->integer(),
            'public' => $this->boolean(),
            'weight' => $this->integer(),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Направление', 'model' => 'Vacancy', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('vacancy');
    }
}
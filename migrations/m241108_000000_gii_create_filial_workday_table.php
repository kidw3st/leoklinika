<?php
use yii\db\Migration;
class m241108_000000_gii_create_filial_workday_table extends Migration
{
    public function up()
    {
        $this->createTable('filial_workday', [
            'id' => $this->primaryKey(),
            'date' => $this->date(),
            'times' => $this->string(255),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Рабочий день (не по расписанию)', 'model' => 'FilialWorkday', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('filial_workday');
    }
}
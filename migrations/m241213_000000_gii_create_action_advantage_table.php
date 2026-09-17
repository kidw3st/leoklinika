<?php
use yii\db\Migration;
class m241213_000000_gii_create_action_advantage_table extends Migration
{
    public function up()
    {
        $this->createTable('action_advantage', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'text' => $this->text(),
            'public' => $this->boolean(),
            'weight' => $this->integer(),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Достижение', 'model' => 'ActionAdvantage', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('action_advantage');
    }
}
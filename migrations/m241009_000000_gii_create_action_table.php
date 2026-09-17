<?php
use yii\db\Migration;
class m241009_000000_gii_create_action_table extends Migration
{
    public function up()
    {
        $this->createTable('action', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'handle' => $this->string(255),
            'image' => $this->string(255),
            'active_from' => $this->dateTime(),
            'active_to' => $this->dateTime(),
            'price' => $this->decimal(10, 2),
            'price_old' => $this->decimal(10, 2),
            'public' => $this->boolean(),
            'weight' => $this->integer(),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Акция', 'model' => 'Action', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('action');
    }
}
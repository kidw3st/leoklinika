<?php
use yii\db\Migration;
class m241023_000000_gii_create_social_table extends Migration
{
    public function up()
    {
        $this->createTable('social', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'type' => $this->string(50),
            'link' => $this->string(255),
            'public' => $this->boolean(),
            'weight' => $this->integer(),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Социальная сеть', 'model' => 'Social', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('social');
    }
}
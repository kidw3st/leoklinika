<?php
use yii\db\Migration;
class m241213_000000_gii_create_action_tag_table extends Migration
{
    public function up()
    {
        $this->createTable('action_tag', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'public' => $this->boolean(),
            'weight' => $this->integer(),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Тег', 'model' => 'ActionTag', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('action_tag');
    }
}
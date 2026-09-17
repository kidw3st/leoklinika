<?php
use yii\db\Migration;
class m241213_000000_gii_create_action_image_table extends Migration
{
    public function up()
    {
        $this->createTable('action_image', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'image' => $this->string(255),
            'action_id' => $this->integer(),
            'public' => $this->boolean(),
            'weight' => $this->integer(),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Изображение', 'model' => 'ActionImage', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('action_image');
    }
}
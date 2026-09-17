<?php
use yii\db\Migration;
class m241108_000000_gii_create_service_video_table extends Migration
{
    public function up()
    {
        $this->createTable('service_video', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'video' => $this->string(255),
            'service_id' => $this->integer(),
            'public' => $this->boolean(),
            'weight' => $this->integer(),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Видео', 'model' => 'ServiceVideo', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('service_video');
    }
}
<?php
use yii\db\Migration;
class m241102_000000_gii_create_video_table extends Migration
{
    public function up()
    {
        $this->createTable('video', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'video' => $this->string(255),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Видео', 'model' => 'Video', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('video');
    }
}
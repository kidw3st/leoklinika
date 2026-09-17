<?php
use yii\db\Migration;
class m220124_000000_gii_create_system_notice_event_table extends Migration
{
    public function up()
    {
        $this->createTable('system_notice_event', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'handle' => $this->string(255),
            'variables' => $this->text(),
            'public' => $this->boolean(),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Событие уведомления', 'model' => 'SystemNoticeEvent', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('system_notice_event');
    }
}
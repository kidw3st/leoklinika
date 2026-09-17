<?php
use yii\db\Migration;
class m220124_000000_gii_create_system_notice_template_email_table extends Migration
{
    public function up()
    {
        $this->createTable('system_notice_template_email', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'subject' => $this->string(255),
            'email_from' => $this->string(255),
            'email_to' => $this->string(1000),
            'email_bcc' => $this->string(1000),
            'text' => $this->text(),
            'event_id' => $this->integer(),
            'public' => $this->boolean(),
        ]);
    }

    public function down()
    {
        $this->dropTable('system_notice_template_email');
    }
}
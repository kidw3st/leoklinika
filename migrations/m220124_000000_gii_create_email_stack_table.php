<?php
use yii\db\Migration;
class m220124_000000_gii_create_email_stack_table extends Migration
{
    public function up()
    {
        $this->createTable('email_stack', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'from' => $this->string(255),
            'to' => $this->string(1000),
            'bcc' => $this->string(1000),
            'text' => $this->text(),
            'priority' => $this->integer(),
            'status' => $this->float(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Стек писем', 'model' => 'EmailStack', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('email_stack');
    }
}
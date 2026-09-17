<?php
use yii\db\Migration;
class m241009_000000_gii_create_member_table extends Migration
{
    public function up()
    {
        $this->createTable('member', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'handle' => $this->string(255),
            'image' => $this->string(255),
            'position' => $this->string(255),
            'education' => $this->string(255),
            'public' => $this->boolean(),
            'weight' => $this->integer(),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Сотрудник', 'model' => 'Member', 'public' => 1]))->controllerSave();
        $this->createTable('member2direct', [
            'member_id' => $this->integer(),
            'direct_id' => $this->integer(),
        ]);
    }

    public function down()
    {
        $this->dropTable('member');
        $this->dropTable('member2direct');
    }
}
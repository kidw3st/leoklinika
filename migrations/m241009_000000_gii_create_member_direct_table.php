<?php
use yii\db\Migration;
class m241009_000000_gii_create_member_direct_table extends Migration
{
    public function up()
    {
        $this->createTable('member_direct', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'public' => $this->boolean(),
            'weight' => $this->integer(),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Направление', 'model' => 'MemberDirect', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('member_direct');
    }
}
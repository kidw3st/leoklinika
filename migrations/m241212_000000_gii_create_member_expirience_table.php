<?php
use yii\db\Migration;
class m241212_000000_gii_create_member_expirience_table extends Migration
{
    public function up()
    {
        $this->createTable('member_expirience', [
            'id' => $this->primaryKey(),
            'from' => $this->integer(),
            'to' => $this->integer(),
            'text' => $this->string(255),
            'member_id' => $this->integer(),
            'public' => $this->boolean(),
            'weight' => $this->integer(),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Опыт', 'model' => 'MemberExpirience', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('member_expirience');
    }
}
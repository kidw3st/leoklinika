<?php
use yii\db\Migration;
class m241204_000000_gii_create_member_qualify_table extends Migration
{
    public function up()
    {
        $this->createTable('member_qualify', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'public' => $this->boolean(),
            'weight' => $this->integer(),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Квалификация', 'model' => 'MemberQualify', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('member_qualify');
    }
}
<?php
use yii\db\Migration;
class m241212_000000_gii_create_member_certificate_table extends Migration
{
    public function up()
    {
        $this->createTable('member_certificate', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'image' => $this->string(255),
            'member_id' => $this->integer(),
            'public' => $this->boolean(),
            'weight' => $this->integer(),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Сертификат', 'model' => 'MemberCertificate', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('member_certificate');
    }
}
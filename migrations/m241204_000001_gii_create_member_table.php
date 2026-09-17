<?php
use yii\db\Migration;
class m241204_000001_gii_create_member_table extends Migration
{
    public function up()
    {
        $this->createTable('member2filial', [
            'member_id' => $this->integer(),
            'filial_id' => $this->integer(),
        ]);
        $this->dropColumn('member', 'education');
    }

    public function down()
    {
        $this->addColumn('member', 'education', $this->string(255));
        $this->dropTable('member2filial');
    }
}
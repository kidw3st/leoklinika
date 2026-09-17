<?php
use yii\db\Migration;
class m241212_000001_gii_create_member_expirience_table extends Migration
{
    public function up()
    {
        $this->dropColumn('member_expirience', 'weight');
    }

    public function down()
    {
        $this->addColumn('member_expirience', 'weight', $this->integer());
    }
}
<?php
use yii\db\Migration;
class m241009_000001_gii_create_member_direct_table extends Migration
{
    public function up()
    {
        $this->addColumn('member_direct', 'title_m', $this->string(255));
    }

    public function down()
    {
        $this->dropColumn('member_direct', 'title_m');
    }
}
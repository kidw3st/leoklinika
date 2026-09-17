<?php
use yii\db\Migration;
class m241102_000002_gii_create_member_table extends Migration
{
    public function up()
    {
        $this->addColumn('member', 'experience', $this->float());
    }

    public function down()
    {
        $this->dropColumn('member', 'experience');
    }
}
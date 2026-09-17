<?php
use yii\db\Migration;
class m241204_000002_gii_create_member_table extends Migration
{
    public function up()
    {
        $this->addColumn('member', 'qualify_id', $this->integer());
        $this->dropColumn('member', 'qualify');
    }

    public function down()
    {
        $this->addColumn('member', 'qualify', $this->string(255));
        $this->dropColumn('member', 'qualify_id');
    }
}
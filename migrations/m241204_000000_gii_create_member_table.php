<?php
use yii\db\Migration;
class m241204_000000_gii_create_member_table extends Migration
{
    public function up()
    {
        $this->addColumn('member', 'qualify', $this->string(255));
        $this->addColumn('member', 'academic', $this->string(255));
        $this->addColumn('member', 'specials', $this->text());
    }

    public function down()
    {
        $this->dropColumn('member', 'qualify');
        $this->dropColumn('member', 'academic');
        $this->dropColumn('member', 'specials');
    }
}
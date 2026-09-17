<?php
use yii\db\Migration;
class m241212_000000_gii_create_member_table extends Migration
{
    public function up()
    {
        $this->addColumn('member', 'education_main', $this->string(255));
        $this->addColumn('member', 'education_intern', $this->string(255));
        $this->addColumn('member', 'education_internat', $this->string(255));
        $this->addColumn('member', 'education_ordinat', $this->string(255));
        $this->addColumn('member', 'education_aspirant', $this->string(255));
        $this->addColumn('member', 'education_special', $this->string(255));
    }

    public function down()
    {
        $this->dropColumn('member', 'education_main');
        $this->dropColumn('member', 'education_intern');
        $this->dropColumn('member', 'education_internat');
        $this->dropColumn('member', 'education_ordinat');
        $this->dropColumn('member', 'education_aspirant');
        $this->dropColumn('member', 'education_special');
    }
}
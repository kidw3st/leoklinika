<?php
use yii\db\Migration;
class m241212_000001_gii_create_member_table extends Migration
{
    public function up()
    {
        $this->dropColumn('member', 'education_internat');
    }

    public function down()
    {
        $this->addColumn('member', 'education_internat', $this->string(255));
    }
}
<?php
use yii\db\Migration;
class m241204_000004_gii_create_member_table extends Migration
{
    public function up()
    {
        $this->dropColumn('member', 'price');
    }

    public function down()
    {
        $this->addColumn('member', 'price', $this->decimal(10, 2));
    }
}
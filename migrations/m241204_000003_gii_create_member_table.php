<?php
use yii\db\Migration;
class m241204_000003_gii_create_member_table extends Migration
{
    public function up()
    {
        $this->addColumn('member', 'price', $this->decimal(10, 2));
    }

    public function down()
    {
        $this->dropColumn('member', 'price');
    }
}
<?php
use yii\db\Migration;
class m241228_000000_gii_create_request_review_table extends Migration
{
    public function up()
    {
        $this->addColumn('request_review', 'text2', $this->text());
    }

    public function down()
    {
        $this->dropColumn('request_review', 'text2');
    }
}
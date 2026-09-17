<?php
use yii\db\Migration;
class m241029_000000_gii_create_request_review_table extends Migration
{
    public function up()
    {
        $this->addColumn('request_review', 'about', $this->string(255));
    }

    public function down()
    {
        $this->dropColumn('request_review', 'about');
    }
}
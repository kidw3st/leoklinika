<?php
use yii\db\Migration;
class m241029_000001_gii_create_request_review_table extends Migration
{
    public function up()
    {
        $this->addColumn('request_review', 'member_id', $this->integer());
        $this->dropColumn('request_review', 'about');
    }

    public function down()
    {
        $this->addColumn('request_review', 'about', $this->string(255));
        $this->dropColumn('request_review', 'member_id');
    }
}
<?php
use yii\db\Migration;
class m241212_000001_gii_create_request_review_table extends Migration
{
    public function up()
    {
        $this->addColumn('request_review', 'phone', $this->string(255));
        $this->addColumn('request_review', 'email', $this->string(80));
    }

    public function down()
    {
        $this->dropColumn('request_review', 'phone');
        $this->dropColumn('request_review', 'email');
    }
}
<?php
use yii\db\Migration;
class m241015_000001_gii_create_request_review_table extends Migration
{
    public function up()
    {
        $this->addColumn('request_review', 'public', $this->boolean());
    }

    public function down()
    {
        $this->dropColumn('request_review', 'public');
    }
}
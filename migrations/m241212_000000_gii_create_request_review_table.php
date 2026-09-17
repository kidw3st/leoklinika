<?php
use yii\db\Migration;
class m241212_000000_gii_create_request_review_table extends Migration
{
    public function up()
    {
        $this->addColumn('request_review', 'answer', $this->text());
        $this->addColumn('request_review', 'answer_date', $this->dateTime());
    }

    public function down()
    {
        $this->dropColumn('request_review', 'answer');
        $this->dropColumn('request_review', 'answer_date');
    }
}
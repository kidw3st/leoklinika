<?php
use yii\db\Migration;
class m241029_000002_gii_create_request_review_table extends Migration
{
    public function up()
    {
        $this->alterColumn('request_review', 'rating', $this->float());
    }

    public function down()
    {
        $this->alterColumn('request_review', 'rating', $this->integer());
    }
}
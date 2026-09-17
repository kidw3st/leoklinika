<?php
use yii\db\Migration;
class m241220_000000_gii_create_news_table extends Migration
{
    public function up()
    {
        $this->addColumn('news', 'text', $this->text());
    }

    public function down()
    {
        $this->dropColumn('news', 'text');
    }
}
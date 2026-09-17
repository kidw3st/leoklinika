<?php
use yii\db\Migration;
class m241206_000001_gii_create_article_table extends Migration
{
    public function up()
    {
        $this->addColumn('article', 'date', $this->dateTime());
    }

    public function down()
    {
        $this->dropColumn('article', 'date');
    }
}
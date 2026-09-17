<?php
use yii\db\Migration;
class m241220_000000_gii_create_article_table extends Migration
{
    public function up()
    {
        $this->addColumn('article', 'text', $this->text());
    }

    public function down()
    {
        $this->dropColumn('article', 'text');
    }
}
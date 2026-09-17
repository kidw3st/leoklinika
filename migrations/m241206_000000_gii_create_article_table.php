<?php
use yii\db\Migration;
class m241206_000000_gii_create_article_table extends Migration
{
    public function up()
    {
        $this->addColumn('article', 'member_id', $this->integer());
    }

    public function down()
    {
        $this->dropColumn('article', 'member_id');
    }
}
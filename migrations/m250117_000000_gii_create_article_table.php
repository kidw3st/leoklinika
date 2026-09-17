<?php
use yii\db\Migration;
class m250117_000000_gii_create_article_table extends Migration
{
    public function up()
    {
        $this->addColumn('article', 'created_at', $this->dateTime());
        $this->addColumn('article', 'updated_at', $this->dateTime());
    }

    public function down()
    {
        $this->dropColumn('article', 'created_at');
        $this->dropColumn('article', 'updated_at');
    }
}
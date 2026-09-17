<?php
use yii\db\Migration;
class m250117_000000_gii_create_news_table extends Migration
{
    public function up()
    {
        $this->addColumn('news', 'created_at', $this->dateTime());
        $this->addColumn('news', 'updated_at', $this->dateTime());
    }

    public function down()
    {
        $this->dropColumn('news', 'created_at');
        $this->dropColumn('news', 'updated_at');
    }
}
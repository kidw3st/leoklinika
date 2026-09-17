<?php
use yii\db\Migration;
class m241204_000005_gii_create_member_table extends Migration
{
    public function up()
    {
        $this->addColumn('member', 'title_seo', $this->string(255));
        $this->addColumn('member', 'text_seo', $this->text());
        $this->addColumn('member', 'text_spoiler', $this->text());
    }

    public function down()
    {
        $this->dropColumn('member', 'title_seo');
        $this->dropColumn('member', 'text_seo');
        $this->dropColumn('member', 'text_spoiler');
    }
}
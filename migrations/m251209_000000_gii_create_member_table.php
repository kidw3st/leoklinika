<?php
use yii\db\Migration;
class m251209_000000_gii_create_member_table extends Migration
{
    public function up()
    {
        $this->addColumn('member', 'seo_title', $this->string(255));
        $this->addColumn('member', 'seo_description', $this->string(500));
        $this->addColumn('member', 'seo_keywords', $this->string(255));
        $this->addColumn('member', 'og_title', $this->string(255));
        $this->addColumn('member', 'og_description', $this->string(500));
        $this->addColumn('member', 'og_image', $this->string(255));
    }

    public function down()
    {
        $this->dropColumn('member', 'seo_title');
        $this->dropColumn('member', 'seo_description');
        $this->dropColumn('member', 'seo_keywords');
        $this->dropColumn('member', 'og_title');
        $this->dropColumn('member', 'og_description');
        $this->dropColumn('member', 'og_image');
    }
}
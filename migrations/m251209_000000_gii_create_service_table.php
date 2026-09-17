<?php
use yii\db\Migration;
class m251209_000000_gii_create_service_table extends Migration
{
    public function up()
    {
        $this->addColumn('service', 'seo_title', $this->string(255));
        $this->addColumn('service', 'seo_description', $this->string(500));
        $this->addColumn('service', 'seo_keywords', $this->string(255));
        $this->addColumn('service', 'og_title', $this->string(255));
        $this->addColumn('service', 'og_description', $this->string(500));
        $this->addColumn('service', 'og_image', $this->string(255));
    }

    public function down()
    {
        $this->dropColumn('service', 'seo_title');
        $this->dropColumn('service', 'seo_description');
        $this->dropColumn('service', 'seo_keywords');
        $this->dropColumn('service', 'og_title');
        $this->dropColumn('service', 'og_description');
        $this->dropColumn('service', 'og_image');
    }
}
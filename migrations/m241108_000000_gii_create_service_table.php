<?php
use yii\db\Migration;
class m241108_000000_gii_create_service_table extends Migration
{
    public function up()
    {
        $this->addColumn('service', 'image', $this->string(255));
        $this->addColumn('service', 'text', $this->text());
        $this->addColumn('service', 'title_seo', $this->string(255));
        $this->addColumn('service', 'text_seo', $this->text());
        $this->addColumn('service', 'text_spoiler', $this->text());
        $this->createTable('service2member', [
            'server_id' => $this->integer(),
            'member_id' => $this->integer(),
        ]);
        $this->createTable('service2related', [
            'service_id' => $this->integer(),
            'related_id' => $this->integer(),
        ]);
    }

    public function down()
    {
        $this->dropColumn('service', 'image');
        $this->dropColumn('service', 'text');
        $this->dropColumn('service', 'title_seo');
        $this->dropColumn('service', 'text_seo');
        $this->dropColumn('service', 'text_spoiler');
        $this->dropTable('service2member');
        $this->dropTable('service2related');
    }
}
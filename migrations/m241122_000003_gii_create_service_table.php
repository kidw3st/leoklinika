<?php
use yii\db\Migration;
class m241122_000003_gii_create_service_table extends Migration
{
    public function up()
    {
        $this->addColumn('service', 'intro_text', $this->string(255));
        $this->addColumn('service', 'intro_image', $this->string(255));
        $this->addColumn('service', 'discount_title', $this->string(255));
        $this->addColumn('service', 'discount_price', $this->decimal(10, 2));
        $this->addColumn('service', 'discount_price_old', $this->decimal(10, 2));
        $this->addColumn('service', 'discount_button', $this->string(255));
        $this->addColumn('service', 'price', $this->decimal(10, 2));
        $this->addColumn('service', 'price_from', $this->boolean());
    }

    public function down()
    {
        $this->dropColumn('service', 'intro_text');
        $this->dropColumn('service', 'intro_image');
        $this->dropColumn('service', 'discount_title');
        $this->dropColumn('service', 'discount_price');
        $this->dropColumn('service', 'discount_price_old');
        $this->dropColumn('service', 'discount_button');
        $this->dropColumn('service', 'price');
        $this->dropColumn('service', 'price_from');
    }
}
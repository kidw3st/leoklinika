<?php
use yii\db\Migration;
class m241023_000000_gii_create_service_table extends Migration
{
    public function up()
    {
        $this->addColumn('service', 'handle_tree', $this->string(500));
        $this->addColumn('service', 'is_popular', $this->boolean());
        $this->addColumn('service', 'lft', $this->integer());
        $this->addColumn('service', 'rgt', $this->integer());
        $this->addColumn('service', 'depth', $this->integer());
        $this->dropColumn('service', 'section_id');
    }

    public function down()
    {
        $this->addColumn('service', 'section_id', $this->integer());
        $this->dropColumn('service', 'handle_tree');
        $this->dropColumn('service', 'is_popular');
        $this->dropColumn('service', 'lft');
        $this->dropColumn('service', 'rgt');
        $this->dropColumn('service', 'depth');
    }
}
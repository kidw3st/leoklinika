<?php
use yii\db\Migration;
class m241213_000002_gii_create_action_table extends Migration
{
    public function up()
    {
        $this->addColumn('action', 'image_detail', $this->string(255));
        $this->addColumn('action', 'description', $this->text());
        $this->addColumn('action', 'button', $this->string(255));
        $this->addColumn('action', 'text', $this->text());
        $this->addColumn('action', 'text_2', $this->text());
    }

    public function down()
    {
        $this->dropColumn('action', 'image_detail');
        $this->dropColumn('action', 'description');
        $this->dropColumn('action', 'button');
        $this->dropColumn('action', 'text');
        $this->dropColumn('action', 'text_2');
    }
}
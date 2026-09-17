<?php
use yii\db\Migration;
class m250114_000000_gii_create_member_table extends Migration
{
    public function up()
    {
        $this->addColumn('member', 'image_video', $this->string(255));
    }

    public function down()
    {
        $this->dropColumn('member', 'image_video');
    }
}
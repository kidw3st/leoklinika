<?php
use yii\db\Migration;
class m241206_000000_gii_create_member_table extends Migration
{
    public function up()
    {
        $this->addColumn('member', 'modal_image', $this->string(255));
        $this->addColumn('member', 'modal_video_id', $this->integer());
    }

    public function down()
    {
        $this->dropColumn('member', 'modal_image');
        $this->dropColumn('member', 'modal_video_id');
    }
}
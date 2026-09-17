<?php
use yii\db\Migration;
class m241120_000000_gii_create_service_video_table extends Migration
{
    public function up()
    {
        $this->addColumn('service_video', 'image', $this->string(255));
    }

    public function down()
    {
        $this->dropColumn('service_video', 'image');
    }
}
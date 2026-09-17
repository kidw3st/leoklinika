<?php
use yii\db\Migration;
class m241204_000000_gii_create_member_image_table extends Migration
{
    public function up()
    {
        $this->createTable('member_image', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'image' => $this->string(255),
            'member_id' => $this->integer(),
            'public' => $this->boolean(),
            'weight' => $this->integer(),
        ]);
    }

    public function down()
    {
        $this->dropTable('member_image');
    }
}
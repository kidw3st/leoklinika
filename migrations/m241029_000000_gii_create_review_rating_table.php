<?php
use yii\db\Migration;
class m241029_000000_gii_create_review_rating_table extends Migration
{
    public function up()
    {
        $this->createTable('review_rating', [
            'id' => $this->primaryKey(),
            'type' => $this->string(50),
            'rating' => $this->float(),
            'link' => $this->string(255),
            'public' => $this->boolean(),
            'weight' => $this->integer(),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Рейтинг внешнего источника', 'model' => 'ReviewRating', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('review_rating');
    }
}
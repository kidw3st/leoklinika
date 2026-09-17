<?php
use yii\db\Migration;
class m241219_000000_gii_create_request_tax_deduction_table extends Migration
{
    public function up()
    {
        $this->createTable('request_tax_deduction', [
            'id' => $this->primaryKey(),
            'patient' => $this->string(50),
            'name' => $this->string(255),
            'birthday' => $this->date(),
            'inn' => $this->string(255),
            'card_number' => $this->string(255),
            'year' => $this->string(255),
            'email' => $this->string(80),
            'phone' => $this->string(255),
            'page_id' => $this->integer(),
            'seo_title' => $this->string(255),
            'seo_description' => $this->string(500),
            'seo_keywords' => $this->string(255),
            'og_title' => $this->string(255),
            'og_description' => $this->string(500),
            'og_image' => $this->string(255),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);
        (new \app\models\SystemAdminMenu(['title' => 'Запрос на налоговый вычет', 'model' => 'RequestTaxDeduction', 'public' => 1]))->controllerSave();
    }

    public function down()
    {
        $this->dropTable('request_tax_deduction');
    }
}
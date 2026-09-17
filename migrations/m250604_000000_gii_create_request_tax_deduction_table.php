<?php
use yii\db\Migration;
class m250604_000000_gii_create_request_tax_deduction_table extends Migration
{
    public function up()
    {
        $this->addColumn('request_tax_deduction', 'relation', $this->string(255));
        $this->addColumn('request_tax_deduction', 'passport', $this->string(255));
        $this->addColumn('request_tax_deduction', 'passport_date', $this->date());
        $this->addColumn('request_tax_deduction', 'patient_name', $this->string(255));
        $this->addColumn('request_tax_deduction', 'patient_inn', $this->string(255));
        $this->addColumn('request_tax_deduction', 'patient_birthday', $this->date());
        $this->addColumn('request_tax_deduction', 'patient_passport', $this->string(255));
        $this->addColumn('request_tax_deduction', 'patient_passport_date', $this->date());
        $this->addColumn('request_tax_deduction', 'delivery_method', $this->string(50));
    }

    public function down()
    {
        $this->dropColumn('request_tax_deduction', 'relation');
        $this->dropColumn('request_tax_deduction', 'passport');
        $this->dropColumn('request_tax_deduction', 'passport_date');
        $this->dropColumn('request_tax_deduction', 'patient_name');
        $this->dropColumn('request_tax_deduction', 'patient_inn');
        $this->dropColumn('request_tax_deduction', 'patient_birthday');
        $this->dropColumn('request_tax_deduction', 'patient_passport');
        $this->dropColumn('request_tax_deduction', 'patient_passport_date');
        $this->dropColumn('request_tax_deduction', 'delivery_method');
    }
}
<?php

use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m210812_100000_user_add_fields extends Migration
{

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('user', 'type', $this->string(50));
        $this->addColumn('user', 'company_name', $this->string(255));
        $this->addColumn('user', 'company_nip', $this->string(20));
        $this->addColumn('user', 'company_regon', $this->string(20));
        $this->addColumn('user', 'company_country', $this->string(255));
        $this->addColumn('user', 'company_voivodeship', $this->string(255));
        $this->addColumn('user', 'company_postcode', $this->string(20));
        $this->addColumn('user', 'company_city', $this->string(100));
        $this->addColumn('user', 'company_street', $this->string(255));
        $this->addColumn('user', 'company_house_no', $this->string(10));
        $this->addColumn('user', 'company_flat_no', $this->string(5));

        $this->addColumn('user', 'house_no', $this->string(10));

        $this->addColumn('user', 'cor_first_name', $this->string(255));
        $this->addColumn('user', 'cor_last_name', $this->string(255));
        $this->addColumn('user', 'cor_country', $this->string(255));
        $this->addColumn('user', 'cor_voivodeship', $this->string(255));
        $this->addColumn('user', 'cor_postcode', $this->string(20));
        $this->addColumn('user', 'cor_city', $this->string(100));
        $this->addColumn('user', 'cor_street', $this->string(255));
        $this->addColumn('user', 'cor_house_no', $this->string(10));
        $this->addColumn('user', 'cor_flat_no', $this->string(5));

        $this->addColumn('user', 'bank_no', $this->string(255));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {

    }
}

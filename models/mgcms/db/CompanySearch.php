<?php

namespace app\models\mgcms\db;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\mgcms\db\Company;
use app\components\mgcms\MgHelpers;

/**
 * app\models\mgcms\db\CompanySearch represents the model behind the search form about `app\models\mgcms\db\Company`.
 */
class CompanySearch extends Company
{

    public $agentCode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'category_id', 'user_id', 'thumbnail_id', 'background_id', 'sale_workers_number'], 'integer'],
            [['name', 'description', 'is_promoted', 'first_name', 'surname', 'status', 'country', 'city', 'postcode', 'street', 'phone', 'email', 'www', 'nip', 'regon', 'krs', 'banc_account_no', 'companycol', 'created_on', 'payment_status', 'paid_from', 'paid_to', 'is_for_sale', 'sale_title', 'sale_description', 'sale_currency', 'sale_price_includes', 'sale_reason', 'sale_business_range', 'sale_sale_range', 'sale_company_profile', 'is_institution', 'institution_agent_prefix', 'companycol1'], 'safe'],
            [['gps_lat', 'gps_long', 'subscription_fee', 'sale_price', 'sale_last_year_income', 'institution_invoice_amount'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Company::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'gps_lat' => $this->gps_lat,
            'gps_long' => $this->gps_long,
            'subscription_fee' => $this->subscription_fee,
            'company.created_by' => $this->created_by,
            'created_on' => $this->created_on,
            'category_id' => $this->category_id,
            'user_id' => $this->user_id,
            'paid_from' => $this->paid_from,
            'paid_to' => $this->paid_to,
            'thumbnail_id' => $this->thumbnail_id,
            'background_id' => $this->background_id,
            'sale_price' => $this->sale_price,
            'sale_workers_number' => $this->sale_workers_number,
            'sale_last_year_income' => $this->sale_last_year_income,
            'institution_invoice_amount' => $this->institution_invoice_amount,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'is_promoted', $this->is_promoted])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'surname', $this->surname])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'postcode', $this->postcode])
            ->andFilterWhere(['like', 'street', $this->street])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'www', $this->www])
            ->andFilterWhere(['like', 'nip', $this->nip])
            ->andFilterWhere(['like', 'regon', $this->regon])
            ->andFilterWhere(['like', 'krs', $this->krs])
            ->andFilterWhere(['like', 'banc_account_no', $this->banc_account_no])
            ->andFilterWhere(['like', 'companycol', $this->companycol])
            ->andFilterWhere(['like', 'payment_status', $this->payment_status])
            ->andFilterWhere(['like', 'is_for_sale', $this->is_for_sale])
            ->andFilterWhere(['like', 'sale_title', $this->sale_title])
            ->andFilterWhere(['like', 'sale_description', $this->sale_description])
            ->andFilterWhere(['like', 'sale_currency', $this->sale_currency])
            ->andFilterWhere(['like', 'sale_price_includes', $this->sale_price_includes])
            ->andFilterWhere(['like', 'sale_reason', $this->sale_reason])
            ->andFilterWhere(['like', 'sale_business_range', $this->sale_business_range])
            ->andFilterWhere(['like', 'sale_sale_range', $this->sale_sale_range])
            ->andFilterWhere(['like', 'sale_company_profile', $this->sale_company_profile])
            ->andFilterWhere(['like', 'is_institution', $this->is_institution])
            ->andFilterWhere(['like', 'institution_agent_prefix', $this->institution_agent_prefix]);

        if ($this->agentCode) {
            $query->orFilterWhere(['company.agent_code' => $this->agentCode]);
        }

        $currentUser = MgHelpers::getUserModel();

        if($currentUser && $currentUser->role == User::ROLE_MANAGER) {
            $query->joinWith('createdBy.createdBy as managerUser');
            $query->orFilterWhere(['managerUser.id' => $currentUser->id]);
        }

        if($currentUser && $currentUser->role == User::ROLE_AGENT) {
            $query->joinWith('createdBy.createdBy as agentUser');
            $query->orFilterWhere(['agentUser.id' => $currentUser->id]);
        }

        if($currentUser && $currentUser->role === User::ROLE_SALES_DIRECTOR ){
            $query->joinWith('createdBy as createdByAgent');
            $query->join('LEFT JOIN','user createdByManager','`createdByAgent`.`created_by` = `createdByManager`.`id`');
            $query->join('LEFT JOIN','user createdBySalesDirector','`createdByManager`.`created_by` = `createdBySalesDirector`.`id`');
            $query->orFilterWhere(['createdBySalesDirector.id' => $currentUser->id]);
            $query->orFilterWhere(['createdByManager.id' => $currentUser->id]);
        }

        if($currentUser && $currentUser->role === User::ROLE_INTERNATIONAL_DIRECTOR ){
            $query->joinWith('createdBy as createdByAgent');
            $query->join('LEFT JOIN','user createdByManager','`createdByAgent`.`created_by` = `createdByManager`.`id`');
            $query->join('LEFT JOIN','user createdBySalesDirector','`createdByManager`.`created_by` = `createdBySalesDirector`.`id`');
            $query->join('LEFT JOIN','user createdByInternationalDirector','`createdBySalesDirector`.`created_by` = `createdByInternationalDirector`.`id`');
            $query->orFilterWhere(['createdByInternationalDirector.id' => $currentUser->id]);
            $query->orFilterWhere(['createdBySalesDirector.id' => $currentUser->id]);
            $query->orFilterWhere(['createdByManager.id' => $currentUser->id]);
        }



        return $dataProvider;
    }
}

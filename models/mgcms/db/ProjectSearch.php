<?php

namespace app\models\mgcms\db;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\mgcms\db\Project;
use app\components\mgcms\MgHelpers;

/**
 * app\models\mgcms\db\ProjectSearch represents the model behind the search form about `app\models\mgcms\db\Project`.
 */
 class ProjectSearch extends Project
{

    public $limit = false;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'file_id', 'percentage', 'percentage_presale_bonus', 'token_value', 'token_to_sale', 'token_minimal_buy', 'token_left', 'created_by'], 'integer'],
            [['name', 'status', 'localization', 'lead', 'text', 'whitepaper', 'www', 'investition_time', 'date_presale_start', 'date_presale_end', 'date_crowdsale_start', 'date_crowdsale_end', 'date_realization_profit', 'token_blockchain'], 'safe'],
            [['gps_lat', 'gps_long', 'money', 'money_full'], 'number'],
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
    public function search($params, $statuses = false)
    {
        $query = Project::find();

        if($statuses){
            $query->andFilterWhere(['in', 'status', $statuses]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'file_id' => $this->file_id,
            'money' => $this->money,
            'money_full' => $this->money_full,
            'percentage' => $this->percentage,
            'date_presale_start' => $this->date_presale_start,
            'date_presale_end' => $this->date_presale_end,
            'date_crowdsale_start' => $this->date_crowdsale_start,
            'date_crowdsale_end' => $this->date_crowdsale_end,
            'percentage_presale_bonus' => $this->percentage_presale_bonus,
            'date_realization_profit' => $this->date_realization_profit,
            'token_value' => $this->token_value,
            'token_to_sale' => $this->token_to_sale,
            'token_minimal_buy' => $this->token_minimal_buy,
            'token_left' => $this->token_left,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'localization', $this->localization])
            ->andFilterWhere(['like', 'lead', $this->lead])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'whitepaper', $this->whitepaper])
            ->andFilterWhere(['like', 'www', $this->www])
            ->andFilterWhere(['like', 'investition_time', $this->investition_time])
            ->andFilterWhere(['like', 'token_blockchain', $this->token_blockchain]);

        if($this->limit){
            $query->limit($this->limit);
        }
        return $dataProvider;
    }
}

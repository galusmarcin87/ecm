<?php

namespace app\models\mgcms\db;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\mgcms\db\Agent;
use app\components\mgcms\MgHelpers;

/**
 * app\models\mgcms\db\AgentSearch represents the model behind the search form about `app\models\mgcms\db\Agent`.
 */
 class AgentSearch extends Agent
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'file_id', 'company_id'], 'integer'],
            [['full_name', 'position', 'description', 'phone', 'email', 'agentcol'], 'safe'],
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
        $query = Agent::find();

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
            'file_id' => $this->file_id,
            'company_id' => $this->company_id,
        ]);

        $query->andFilterWhere(['like', 'full_name', $this->full_name])
            ->andFilterWhere(['like', 'position', $this->position])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'agentcol', $this->agentcol]);

        return $dataProvider;
    }
}

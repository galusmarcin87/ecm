<?php

namespace app\models\mgcms\db;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\mgcms\db\FaqItem;
use app\components\mgcms\MgHelpers;

/**
 * app\models\mgcms\db\FaqItemSearch represents the model behind the search form about `app\models\mgcms\db\FaqItem`.
 */
 class FaqItemSearch extends FaqItem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'faq_id', 'order'], 'integer'],
            [['question', 'answer', 'content'], 'safe'],
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
        $query = FaqItem::find();

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
            'faq_id' => $this->faq_id,
            'order' => $this->order,
        ]);

        $query->andFilterWhere(['like', 'question', $this->question])
            ->andFilterWhere(['like', 'answer', $this->answer])
            ->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}

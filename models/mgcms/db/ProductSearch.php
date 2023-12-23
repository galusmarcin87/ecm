<?php

namespace app\models\mgcms\db;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\mgcms\db\Product;
use app\components\mgcms\MgHelpers;

/**
 * app\models\mgcms\db\ProductSearch represents the model behind the search form about `app\models\mgcms\db\Product`.
 */
 class ProductSearch extends Product
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'number', 'min_amount_of_purchase', 'company_id', 'file_id'], 'integer'],
            [['name', 'created_on', 'description', 'specification', 'is_special_offer', 'special_offer_from', 'special_offer_to'], 'safe'],
            [['price', 'special_offer_price'], 'number'],
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
        $query = Product::find();

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
            'created_on' => $this->created_on,
            'category_id' => $this->category_id,
            'price' => $this->price,
            'number' => $this->number,
            'special_offer_from' => $this->special_offer_from,
            'special_offer_to' => $this->special_offer_to,
            'min_amount_of_purchase' => $this->min_amount_of_purchase,
            'special_offer_price' => $this->special_offer_price,
            'company_id' => $this->company_id,
            'file_id' => $this->file_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'specification', $this->specification])
            ->andFilterWhere(['like', 'is_special_offer', $this->is_special_offer]);

        return $dataProvider;
    }
}

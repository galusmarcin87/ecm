<?php

namespace app\models\mgcms\db;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\mgcms\db\Category;

/**
 * app\models\mgcms\db\CategorySearch represents the model behind the search form about `app\models\mgcms\db\Category`.
 */
 class CategorySearch extends Category
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'order', 'promoted'], 'integer'],
            [['name', 'slug', 'type', 'custom', 'language'], 'safe'],
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
        $query = Category::find();

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
            'parent_id' => $this->parent_id,
            'order' => $this->order,
            'promoted' => $this->promoted,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'custom', $this->custom])
            ->andFilterWhere(['like', 'language', $this->language]);

        return $dataProvider;
    }
}

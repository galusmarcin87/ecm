<?php
namespace app\models\mgcms\db;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\mgcms\db\File;

/**
 * app\models\mgcms\db\ArticleSearch represents the model behind the search form about `app\models\mgcms\db\Article`.
 */
class FileSearch extends File
{

  /**
   * @inheritdoc
   */
  public function rules()
  {
    return [
        [['name', 'origin_name', 'created_on'], 'safe'],
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
    $query = File::find();

    $dataProvider = new ActiveDataProvider([
        'query' => $query,
        'sort' => ['defaultOrder' => ['created_on' => SORT_DESC]]
    ]);

    $this->load($params);

    if (!$this->validate()) {
      // uncomment the following line if you do not want to return any records when validation fails
      // $query->where('0=1');
      return $dataProvider;
    }

    $query->andFilterWhere([
        'id' => $this->id,
    ]);

    $query->andFilterWhere(['like', 'name', $this->name])
        ->andFilterWhere(['like', 'origin_name', $this->origin_name])
        ->andFilterWhere(['like', 'created_on', $this->created_on]);

    return $dataProvider;
  }
}

<?php
namespace app\models\mgcms\db;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\mgcms\db\Article;

/**
 * app\models\mgcms\db\ArticleSearch represents the model behind the search form about `app\models\mgcms\db\Article`.
 */
class ArticleSearch extends Article
{

  /**
   * @inheritdoc
   */
  public function rules()
  {
    return [
        [['id', 'created_by', 'updated_by', 'parent_id', 'category_id', 'file_id', 'order', 'promoted'], 'integer'],
        [['title', 'content', 'slug', 'excerpt', 'language', 'created_on', 'updated_on', 'meta_title', 'meta_description', 'meta_keywords', 'status', 'custom', 'type'], 'safe'],
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
    $query = Article::find();

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
        'created_on' => $this->created_on,
        'updated_on' => $this->updated_on,
        'created_by' => $this->created_by,
        'updated_by' => $this->updated_by,
        'parent_id' => $this->parent_id,
        'category_id' => $this->category_id,
        'file_id' => $this->file_id,
        'order' => $this->order,
        'promoted' => $this->promoted,
    ]);

    $query->andFilterWhere(['like', 'title', $this->title])
        ->andFilterWhere(['like', 'content', $this->content])
        ->andFilterWhere(['like', 'slug', $this->slug])
        ->andFilterWhere(['like', 'excerpt', $this->excerpt])
        ->andFilterWhere(['like', 'language', $this->language])
        ->andFilterWhere(['like', 'meta_title', $this->meta_title])
        ->andFilterWhere(['like', 'meta_description', $this->meta_description])
        ->andFilterWhere(['like', 'meta_keywords', $this->meta_keywords])
        ->andFilterWhere(['like', 'status', $this->status])
        ->andFilterWhere(['like', 'custom', $this->custom])
        ->andFilterWhere(['like', 'type', $this->type]);

    return $dataProvider;
  }
}

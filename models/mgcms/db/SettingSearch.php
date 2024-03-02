<?php
namespace app\models\mgcms\db;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\mgcms\db\Setting;

/**
 * app\models\mgcms\db\UserSearch represents the model behind the search form about `app\models\mgcms\db\User`.
 */
class SettingSearch extends Setting
{

  /**
   * @inheritdoc
   */
  public function rules()
  {
    return [
        [['value', 'value_text', 'type'], 'string'],
        [['key', 'value', 'value_text'], 'safe'],
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
    $query = Setting::find();

    $dataProvider = new ActiveDataProvider([
        'query' => $query,
    ]);

    $this->load($params);

    if (!$this->validate()) {
      // uncomment the following line if you do not want to return any records when validation fails
      // $query->where('0=1');
      return $dataProvider;
    }

    $query->andFilterWhere(['like', 'key', $this->key])
        ->andFilterWhere(['like', 'value', $this->value])
        ->andFilterWhere(['like', 'value_text', $this->value_text])
        ->andWhere(['type' => $this->type]);

    return $dataProvider;
  }
}

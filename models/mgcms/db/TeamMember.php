<?php
namespace app\models\mgcms\db;

use Yii;
use app\components\mgcms\MgHelpers;

/**
 * This is the base model class for table "team_member".
 *
 * @property integer $id
 * @property string $name
 * @property string $surname
 * @property integer $is_team
 * @property integer $is_consultant
 * @property string $phone
 * @property string $description
 * @property integer $file_id
 * @property File $file
 */
class TeamMember extends \app\models\mgcms\db\AbstractRecord
{

  use LanguageBehaviorTrait;

  public $languageAttributes = ['description'];

  /**
   * @inheritdoc
   */
  public function rules()
  {
    return [
        [['name'], 'required'],
        [['name', 'surname', 'phone'], 'string', 'max' => 45],
        [['is_team', 'is_consultant'], 'string', 'max' => 1],
        [['description'], 'safe'],
        [['file_id'], 'integer'],
    ];
  }

  /**
   * @inheritdoc
   */
  public static function tableName()
  {
    return 'team_member';
  }

  /**
   * @inheritdoc
   */
  public function attributeLabels()
  {
    return [
        'id' => Yii::t('app', 'ID'),
        'name' => Yii::t('app', 'Imię'),
        'surname' => Yii::t('app', 'Nazwisko'),
        'is_team' => Yii::t('app', 'Jest w zespole'),
        'is_consultant' => Yii::t('app', 'Jest konsultantem'),
        'phone' => Yii::t('app', 'Email'),
        'description' => Yii::t('app', 'Description'),
        'file_id' => Yii::t('app', 'Photo'),
        'file' => Yii::t('app', 'Photo'),
    ];
  }

  /**
   * @inheritdoc
   * @return \app\models\mgcms\db\TeamMemberQuery the active query used by this AR class.
   */
  public static function find()
  {
    return new \app\models\mgcms\db\TeamMemberQuery(get_called_class());
  }
  
  /**
   * @return File
   */
  public function getFile()
  {
    return $this->hasOne(\app\models\mgcms\db\File::className(), ['id' => 'file_id']);
  }
}

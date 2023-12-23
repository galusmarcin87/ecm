<?php
namespace app\models;

use Yii;
use yii\base\Model;
use app\components\mgcms\T;
use kartik\password\StrengthValidator;
use \app\components\mgcms\MgHelpers;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class ResetPasswordForm extends Model
{

  public $username;
  public $password;
  public $passwordRepeat;
  private $_user = false;

  public function __construct(mgcms\db\User $user)
  {
    $this->_user = $user;
    $this->username = $user->username;
  }

  /**
   * @return array the validation rules.
   */
  public function rules()
  {
    return [
        // username and password are both required
        [['password', 'passwordRepeat'], 'required'],
        // rememberMe must be a boolean value
        // password is validated by validatePassword()
        [['password'], StrengthValidator::className(), 'min' => 8, 'digit' => 1, 'special' => 1, 'upper' => 1, 'lower' => 1, 'userAttribute' => 'username'],
        ['passwordRepeat', 'compare', 'compareAttribute' => 'password', 'message' => Yii::t('app', "Passwords don't match")],
    ];
  }



  public function changePassword()
  {
    if ($this->validate()) {
      $this->_user->password = $this->password;

      $saved = $this->_user->save();
      if ($saved) {
        Yii::$app->getResponse()->redirect(['/site/login']);
      }else{
        $this->_user = null;
        MgHelpers::setFlashError(MgHelpers::getErrorsString($this->_user->getErrors()));
      }

      return false;
    }

    return false;
  }

  public function setUser(mgcms\db\User $user)
  {
    $this->_user = $user;
  }

  /**
   * Finds user by [[username]]
   *
   * @return User|null
   */
  public function getUser()
  {
    return $this->_user;
  }

  public function attributeLabels()
  {
    return [
        'password' => Yii::t('app', 'Password'),
        'passwordRepeat' => Yii::t('app', 'Password repeat'),
        'is_password_change_accepted' => 'Akceptuję cykliczną zmianę hasła'
    ];
  }
}

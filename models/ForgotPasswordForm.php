<?php
namespace app\models;

use Yii;
use yii\base\Model;
use app\components\mgcms\T;
use app\models\mgcms\db\Log;
use app\components\mgcms\MgHelpers;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class ForgotPasswordForm extends Model
{

  public $email;
  public $birthdate;

  /**
   * @return array the validation rules.
   */
  public function rules()
  {
    return [
        // username and password are both required
        [['email'], 'required'],
        [['email'], 'checkExistUser'],
    ];
  }

  function checkExistUser($attribute)
  {
    if (!$this->hasErrors()) {
      $user = mgcms\db\User::find()->where(['username' => $this->email])->one();
      if (!$user) {
        $this->addError($attribute, Yii::t('app', 'User with this email does not exist.'));
      }
    }
  }

  /**
   * Logs in a user using the provided username and password.
   * @return bool whether the user is logged in successfully
   */
  public function sendMail()
  {
    if ($this->validate()) {
      Yii::$app->mailer->compose('forgotPassword', [
              'model' => $this
          ])
          ->setTo($this->email)
          ->setFrom([MgHelpers::getSetting('email') => MgHelpers::getSetting('email nazwa')])
          ->setSubject(Yii::t('db', 'Forgot password'))
          ->send();
      return true;
    }
    return false;
  }

  public function attributeLabels()
  {
    return [
        'username' => T::t('email'),
        'birthdate' => 'Data urodzenia'
    ];
  }
}

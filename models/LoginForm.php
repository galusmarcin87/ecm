<?php

namespace app\models;

use app\components\mgcms\MgHelpers;
use Yii;
use yii\base\Model;
use app\components\mgcms\T;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{

    public $username;
    public $password;
    public $rememberMe = true;
    private $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, Yii::t('db', 'Incorrect username or password.'));
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        Yii::$app->user->on(\yii\web\User::EVENT_AFTER_LOGIN, function ($event) {
            $event->identity->updateLastLogin();
        });
        if ($this->validate()) {
            if ($this->getUser()->status == mgcms\db\User::STATUS_INACTIVE) {
                MgHelpers::setFlashError(Yii::t('db', 'Your account is not activated. Check Your email for activation link'));
                $this->addError('username', Yii::t('db', 'Your account is not activated. Check Your email for activation link'));
                return false;
            }
            if ($this->getUser()->status == mgcms\db\User::STATUS_SUSPENDED) {
                MgHelpers::setFlashError(Yii::t('db', 'Your account is suspended. Contact with us'));
                $this->addError('username', Yii::t('db', 'Your account is suspended. Contact with us'));
                return false;
            }

            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            MgHelpers::setFlashError(Yii::t('db', 'Invalid username or password'));
            //Yii::$app->response->redirect(Yii::$app->request->url);
        }
        return false;
    }


    public function login2step()
    {
        Yii::$app->user->on(\yii\web\User::EVENT_AFTER_LOGIN, function ($event) {
            $event->identity->updateLastLogin();
        });
        if ($this->validate()) {
            if ($this->getUser()->status == mgcms\db\User::STATUS_INACTIVE) {
                MgHelpers::setFlashError(Yii::t('db', 'Your account is not activated. Check Your email for activation link'));
                $this->addError('username', Yii::t('db', 'Your account is not activated. Check Your email for activation link'));
                return false;
            }
            if ($this->getUser()->status == mgcms\db\User::STATUS_SUSPENDED) {
                MgHelpers::setFlashError(Yii::t('db', 'Your account is suspended. Contact with us'));
                $this->addError('username', Yii::t('db', 'Your account is suspended. Contact with us'));
                return false;
            }

            return true;
        } else {
            MgHelpers::setFlashError(Yii::t('db', 'Invalid username or password'));
            //Yii::$app->response->redirect(Yii::$app->request->url);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = mgcms\db\User::find()->where(['username' => $this->username])->one();
        }

        return $this->_user;
    }

    public function attributeLabels()
    {
        return [
            'username' => Yii::t('db', 'E-mail address'),
            'password' => Yii::t('db', 'Password'),
            'rememberMe' => T::t('Remember me'),
        ];
    }
}

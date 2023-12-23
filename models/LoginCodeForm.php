<?php

namespace app\models;

use app\components\mgcms\MgHelpers;
use Yii;
use yii\base\Model;
use app\components\mgcms\T;
use yii\db\Expression;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginCodeForm extends Model
{

    public $code;
    public $userId;
    public $rememberMe;
    private $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['code', 'userId'], 'required'],
            ['rememberMe', 'boolean'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'code' => Yii::t('db', 'Login code sent by email'),
        ];
    }

    public function generateCode()
    {
        if (!$this->getUser()) {
            throw new \yii\base\InvalidArgumentException();
        }
        return substr(md5($this->getUser()->id . $this->getUser()->last_login), 0, 6);
    }

    public function verifyCode()
    {
        if ($this->code !== $this->generateCode()) {
            $this->addError('code', Yii::t('db', 'Incorrect code.'));
            return false;
        }
        return true;
    }

    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = mgcms\db\User::find()->where(['id' => $this->userId])->one();
        }

        return $this->_user;
    }

    public function login()
    {
        $this->getUser()->last_login = new Expression('NOW()');
        $this->getUser()->save();
        return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);

    }
}

<?php

namespace app\modules\backend\controllers\mgcms;

use app\models\mgcms\db\Company;
use app\models\mgcms\db\User;
use Yii;
use app\models\mgcms\db\Auth;
use app\models\mgcms\db\AuthSearch;
use app\modules\backend\components\mgcms\MgBackendController;
use yii\db\Connection;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\mgcms\MgHelpers;

/**
 * AuthController implements the CRUD actions for Auth model.
 */
class StatsController extends MgBackendController
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Auth models.
     * @return mixed
     */
    public function actionIndex()
    {
        $connection = Yii::$app->getDb();

        $companiesByDay = $connection->createCommand("SELECT DATE_FORMAT(created_on, '%Y-%m-%d') as date , COUNT(*) AS `cnt` FROM `company` GROUP BY DATE_FORMAT(created_on, '%Y-%m-%d') ORDER BY YEAR(created_on) DESC, MONTH(created_on) DESC, DAY(created_on) DESC")->queryAll();
        $companiesByMonth = $connection->createCommand("SELECT DATE_FORMAT(created_on, '%Y-%m') as month , COUNT(*) AS `cnt` FROM `company` GROUP BY DATE_FORMAT(created_on, '%Y-%m') ORDER BY YEAR(created_on) DESC, MONTH(created_on) DESC")->queryAll();
        $companiesByQuarter = $connection->createCommand("SELECT YEAR(created_on) AS year, QUARTER(created_on) AS quarter , COUNT(*) AS `cnt` FROM `company` GROUP BY YEAR(created_on), QUARTER(created_on)  ORDER BY YEAR(created_on) DESC, QUARTER(created_on) DESC")->queryAll();

        return $this->render('index', [
            'companiesByDay' => $companiesByDay,
            'companiesByMonth' => $companiesByMonth,
            'companiesByQuarter' => $companiesByQuarter
        ]);
    }

    /**
     * @param Company[] $companies
     */
    private function _pushUsers(\app\models\mgcms\db\User &$parent, &$companies)
    {
        $users = \app\models\mgcms\db\User::find()->where(['created_by' => $parent->id])->all();
        $parent->children = $users;
        foreach ($parent->children as &$user) {
            foreach ($user->companies as $company) {
                $companies[$company->id] = $company;
            }
            self::_pushUsers($user, $companies);
        }
    }

    private function _increaseProvisionForUser($amount, $userId, &$provisions)
    {
        if (isset($provisions[$userId])) {
            $provisions[$userId] += $amount;
        } else {
            $provisions[$userId] = $amount;
        }
    }

    private function _setProvisionForCompany(Company $company, &$provisions)
    {
        $user = $company->createdBy;
        $provisionForUser = 0;
        $provisionForParentUser = 0;
        $provisionForParentParentUser = 0;
        $provisionForParentParentParentUser = 0;
        $provisionSetting = [];
        $provisionSetting[User::ROLE_AGENT] = MgHelpers::getSetting('provision ' . User::ROLE_AGENT, false, 250);
        $provisionSetting[User::ROLE_MANAGER] = MgHelpers::getSetting('provision ' . User::ROLE_MANAGER, false, 350);
        $provisionSetting[User::ROLE_SALES_DIRECTOR] = MgHelpers::getSetting('provision ' . User::ROLE_SALES_DIRECTOR, false, 400);
        $provisionSetting[User::ROLE_INTERNATIONAL_DIRECTOR] = MgHelpers::getSetting('provision ' . User::ROLE_INTERNATIONAL_DIRECTOR, false, 500);

        switch ($user->role) {
            case User::ROLE_AGENT:
                $provisionForUser = $provisionSetting[$user->role];
                $provisionForParentUser = $provisionSetting[User::ROLE_MANAGER] - $provisionSetting[$user->role];
                $provisionForParentParentUser = $provisionSetting[User::ROLE_SALES_DIRECTOR] - $provisionSetting[User::ROLE_MANAGER];
                $provisionForParentParentParentUser = $provisionSetting[User::ROLE_INTERNATIONAL_DIRECTOR] - $provisionSetting[User::ROLE_SALES_DIRECTOR];
                break;
            case User::ROLE_MANAGER:
                $provisionForUser = $provisionSetting[$user->role];
                $provisionForParentUser = $provisionSetting[User::ROLE_SALES_DIRECTOR] - $provisionSetting[User::ROLE_MANAGER];
                $provisionForParentParentUser = $provisionSetting[User::ROLE_INTERNATIONAL_DIRECTOR] - $provisionSetting[User::ROLE_SALES_DIRECTOR];
                break;
            case User::ROLE_SALES_DIRECTOR:
                $provisionForUser = $provisionSetting[$user->role];
                $provisionForParentUser = $provisionSetting[User::ROLE_INTERNATIONAL_DIRECTOR] - $provisionSetting[User::ROLE_SALES_DIRECTOR];
                break;
            case User::ROLE_INTERNATIONAL_DIRECTOR:
                $provisionForUser = $provisionSetting[$user->role];
                break;
        }

        self::_increaseProvisionForUser($provisionForUser, $user->id, $provisions);
        if ($user->created_by) {
            self::_increaseProvisionForUser($provisionForParentUser, $user->createdBy->id, $provisions);
            if ($user->createdBy->createdBy) {
                self::_increaseProvisionForUser($provisionForParentParentUser, $user->createdBy->createdBy->id, $provisions);
                if ($user->createdBy->createdBy->createdBy) {
                    self::_increaseProvisionForUser($provisionForParentParentParentUser, $user->createdBy->createdBy->createdBy->id, $provisions);
                }
            }
        }

    }

    public function actionProvisions()
    {
        $provisions = [];
        $companies = [];
        $user = $this->getUserModel();
        $tree = self::_pushUsers($user, $companies);

        foreach ($companies as $company) {
            self::_setProvisionForCompany($company, $provisions);
        }

        return $this->render('provisions', ['provisions' => $provisions, 'user' => $user]);
    }

}

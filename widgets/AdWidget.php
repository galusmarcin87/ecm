<?php
namespace app\widgets;

use Yii;
use app\models\mgcms\db\Ad;

class AdWidget extends \yii\bootstrap\Widget
{


    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $ip = Yii::$app->request->userIP;
        $country = Yii::$app->ip2location->getCountryCode($ip);
        $ads = Ad::find()->where(['country' => $country, 'status' => Ad::STATUS_APPROVED])->andWhere(['>', 'date_to', date('Y-m-d')])->all();
        return $this->render('adWidget', ['ads' => $ads]);
    }
}

<?
/* @var $this yii\web\View */

use app\components\mgcms\MgHelpers;
use yii\web\View;
use yii\widgets\ListView;
use app\models\mgcms\db\User;

$registeredInvestorsCount = User::find()->where(['role' => [User::ROLE_INVESTOR_NOT_EXPERIENCED, User::ROLE_INVESTOR_EXPERIENCED, User::ROLE_INVESTOR_EXPERIENCED_NOT_CONFIRMED]])->count();
$investitionsCount = \app\models\mgcms\db\Project::find()->count();
$collectedFunds = \app\models\mgcms\db\Payment::find()->sum('amount');
$plannedInvestitionsCount = \app\models\mgcms\db\Project::find()->where(['status' => \app\models\mgcms\db\Project::STATUS_PLANNED])->count();
?>
<div class="section section-counters">
    <div class="container">
        <div class="row gy-5">


            <div class="col-lg-3 counters-col">
                <div class="counters-item">
                    <div class="icon">
                        <img class="icon-img" src="/images/counters1.svg" alt="">
                    </div>


                    <div class="text">
                        <h3>
                        <span class="counter">
                            <span class="count-wrap">
                            <span class="count"
                                  data-duration=""
                                  data-refresh-interval="10"
                                  data-from="0"
                                  data-decimals=""
                                  data-to="<?= $registeredInvestorsCount ?>>"><?= $registeredInvestorsCount ?>
                                </span>
                                <span class="postfix"></span>
                            </span>
                        </h3>
                        <p>

                            <?= Yii::t('db', 'registered investors') ?>

                        </p>


                    </div>
                </div>
            </div>


            <div class="col-lg-3 counters-col">
                <div class="counters-item">
                    <div class="icon">
                        <img class="icon-img" src="/images/counters2.svg" alt="">
                    </div>


                    <div class="text">
                        <h3>
                        <span class="counter">
                            <span class="count-wrap">
                            <span class="count"
                                  data-duration=""
                                  data-refresh-interval="10"
                                  data-from="0"
                                  data-decimals=""
                                  data-to="<?= $investitionsCount ?>"><?= $investitionsCount ?>
                                </span>
                                <span class="postfix"></span>
                            </span>
                        </h3>
                        <p>

                            <?= Yii::t('db', 'investitions') ?>

                        </p>


                    </div>
                </div>
            </div>


            <div class="col-lg-3 counters-col">
                <div class="counters-item">
                    <div class="icon">
                        <img class="icon-img" src="/images/counters3.svg" alt="">
                    </div>


                    <div class="text">
                        <h3>
                        <span class="counter">
                            <span class="count-wrap">
                            <span class="count"
                                  data-duration=""
                                  data-refresh-interval="10"
                                  data-from="0"
                                  data-decimals=""
                                  data-to="<?= $collectedFunds ?>"><?= $collectedFunds ?>
                                </span>
                                <span class="postfix">PLN</span>
                            </span>
                        </h3>
                        <p>

                            <?= Yii::t('db', 'collected funds') ?>

                        </p>


                    </div>
                </div>
            </div>


            <div class="col-lg-3 counters-col">
                <div class="counters-item">
                    <div class="icon">
                        <img class="icon-img" src="/images/counters4.svg" alt="">
                    </div>


                    <div class="text">
                        <h3>
                        <span class="counter">
                            <span class="count-wrap">
                            <span class="count"
                                  data-duration=""
                                  data-refresh-interval="10"
                                  data-from="0"
                                  data-decimals=""
                                  data-to="<?= $plannedInvestitionsCount ?>"><?= $plannedInvestitionsCount ?>
                                </span>
                                <span class="postfix"></span>
                            </span>
                        </h3>
                        <p>

                            <?= Yii::t('db', 'upcoming campaigns') ?>

                        </p>


                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

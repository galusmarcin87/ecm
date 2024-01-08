<?php
/* @var $this yii\web\View */

use app\models\mgcms\db\Project;
use app\models\mgcms\db\ProjectSearch;
use app\models\mgcms\db\User;
use kartik\grid\GridView;
use kartik\helpers\Html;
use yii\data\ActiveDataProvider;
use yii\widgets\ListView;
use app\components\mgcms\MgHelpers;

$this->title = Yii::t('db', 'Investitions');

$searchModel = new \app\models\mgcms\db\PaymentSearch();
$searchModel->user_id = MgHelpers::getUserModel()->id;
$dataProvider = $searchModel->search(Yii::$app->request->queryParams);


?>

<?= $this->render('/common/breadcrumps') ?>
<?= $this->render('_investor') ?>


<div class="account-page">
    <div class="container">


        <div class="row gx-4">
            <?= $this->render('_leftNav', ['tab' => $tab]) ?>
            <div class="col-lg-10 account-content-col">


                <div class="row">
                    <div class="col-12">
                        <a href="<?= \yii\helpers\Url::to('/site/knowledge-test') ?>" class="btn btn-primary">
                            <?= Yii::t('db', 'Apply for experienced investor status') ?>
                        </a>
                    </div>
                </div>

                <div class="account-filters hidden">
                    <div class="row">
                        <div class="col-lg-3">
                            <label for="sort" class="form-label">Sortuj</label>
                            <select name="sort" id="sort" class="form-select">
                                <option value="newest">Oczekujące na start</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label for="date_from" class="form-label">Data wystąpienia</label>
                            <div class="row">
                                <div class="col-6">
                                    <div class="field-has-label mb-3">
                                        <input type="date" class="form-control" id="date_from" placeholder="Od">
                                        <label for="floatingInput">Od</label>
                                    </div>

                                </div>
                                <div class="col-6">
                                    <div class="field-has-label mb-3">
                                        <input type="date" class="form-control" id="date_to" placeholder="Do">
                                        <label for="floatingInput">Do</label>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="col-lg-3">
                            <label for="date_from" class="form-label">Data zakończenia</label>
                            <div class="row">
                                <div class="col-6">
                                    <div class="field-has-label mb-3">
                                        <input type="date" class="form-control" id="date_from" placeholder="Od">
                                        <label for="floatingInput">Od</label>
                                    </div>

                                </div>
                                <div class="col-6">
                                    <div class="field-has-label mb-3">
                                        <input type="date" class="form-control" id="date_to" placeholder="Do">
                                        <label for="floatingInput">Do</label>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="col-lg-3">
                            <label for="name" class="form-label">Nazwa</label>
                            <input type="text" class="form-control" name="name" id="name">

                        </div>
                    </div>
                </div>

                <div class="row mb-5 hidden">
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary">Filtruj</button>
                    </div>
                </div>

                <?php
                $gridColumn = [
                    ['class' => 'yii\grid\SerialColumn', 'header' => 'Lp.'],
                    'project.name',
                    'created_on',
                    'project.money',
                    'amount',
                    'amountOfShares',
                    'project.statusStr'
                ];
                ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $gridColumn,
                    'filterRowOptions' => ['class' => ''],
                    'pjax' => true,
                    'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-project']],
                    // your toolbar can include the additional full export menu
                ]); ?>


            </div>
        </div>

        <?= $this->render('_greenBar') ?>

    </div>


    <div class="container py-5">
        <div class="row">
            <div class="col-lg-10 ms-lg-auto">

                <h3 class="fw-semibold mb-5 text-center">
                    <?= Yii::t('db', 'What are benefits of being experienced investor?') ?>
                </h3>


                <div class="advantages pt-5">


                    <div class="advantages-item">
                        <div class="advantages-icon">
                            <img src="/images/icons/wartosc.svg" alt="">
                        </div>
                        <div class="advantages-title">
                            <?= MgHelpers::getSettingTypeText('my account experienced investor benefits 1', false, 'my account experienced investor benefits 1') ?>

                        </div>
                    </div>


                    <div class="advantages-item">
                        <div class="advantages-icon">
                            <img src="/images/icons/walidacja.svg" alt="">
                        </div>
                        <div class="advantages-title">
                            <?= MgHelpers::getSettingTypeText('my account experienced investor benefits 2', false, 'my account experienced investor benefits 2') ?>
                        </div>
                    </div>


                    <div class="advantages-item">
                        <div class="advantages-icon">
                            <img src="/images/icons/ukryte_koszty.svg" alt="">
                        </div>
                        <div class="advantages-title">
                            <?= MgHelpers::getSettingTypeText('my account experienced investor benefits 3', false, 'my account experienced investor benefits 3') ?>
                        </div>
                    </div>


                    <div class="advantages-item">
                        <div class="advantages-icon">
                            <img src="/images/icons/zysk.svg" alt="">
                        </div>
                        <div class="advantages-title">
                            <?= MgHelpers::getSettingTypeText('my account experienced investor benefits 4', false, 'my account experienced investor benefits 4') ?>
                        </div>
                    </div>


                </div>


            </div>
        </div>
    </div>


</div>

<?php
/* @var $this yii\web\View */

/* @var $model \app\models\mgcms\db\User */

use app\models\mgcms\db\Project;
use yii\data\ActiveDataProvider;
use yii\widgets\ListView;
use yii\helpers\Url;


$this->title = Yii::t('db', 'Buy token');
?>
<?= $this->render('/common/breadcrumps', ['displayBg' => true, 'cssClass' => 'page-header-text', ]) ?>
<?= $this->render('_investor') ?>

    <div class="container">


        <div class="row gx-4">

            <?= $this->render('_leftNav', ['tab' => $tab]) ?>
        </div>
    </div>

<div class="account-page">

<div class="lg py-12 ">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="pe-lg-5"><br>
                    <center><h4 class="font-oswald mb-4"><?= Yii::t('db', 'Buy token ECM') ?></h4></center>
					<center><div class="mb-2"><img src="/images/logo_ecm.png" alt="ECM Logo" style="height: 80px;"></div></center>
                    <div class="text-center mb-4">
						<a href="/project/buy?id=30" class="btn btn-primary" role="button">
							<center><?= Yii::t('db', 'KUP TOKEN EKOSYSTEMU ECM') ?></center>
						</a>
					</div>
                </div>
            </div>
            <div class="col-lg-6">
				 <div class="bg-decoration-content">
                	<div class="ps-lg-5"><br>
						<div class="row">
							<center><h4 class="font-oswald mb-4"><?= Yii::t('db', 'Buy token SDT') ?></h4></center>
							<center><div class="mb-2"><img src="/images/logo_sdt1.png" alt="SDT1 LAB ONE Logo" style="height: 80px;"></div></center>
                    <div class="text-center mb-4">
						<a href="/project/buy?id=34" class="btn btn-primary" role="button">
							<center><?= Yii::t('db', 'KUP TOKEN MOCY SDT1 LAB ONE') ?></center>
						</a>
					</div>
						</div>
					</div>
				</div>
            </div>
        </div><br><br>
    </div>
</div>
	
</div>

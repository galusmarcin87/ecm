<?php
/* @var $model app\models\mgcms\db\Project */
/* @var $form app\components\mgcms\yii\ActiveForm */

/* @var $this yii\web\View */

/* @var $subscribeForm \app\models\SubscribeForm */

use app\components\mgcms\MgHelpers;
use yii\web\View;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use  \app\models\mgcms\db\Project;


$this->title = $model->name;
$model->language = Yii::$app->language;


//$this->params['breadcrumbs'][] = [\yii\helpers\Url::to('/project/index'), Yii::t('db', 'Campaigns')];
?>

<?= $this->render('/common/sideSocialButtons') ?>
<?= $this->render('/common/breadcrumps', ['displayBg' => true, 'cssClass' => 'page-header-text']) ?>

<?= $this->render('view/view' . $model->type, ['model' => $model]) ?>

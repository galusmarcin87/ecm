<?
/* @var $this yii\web\View */

use app\components\mgcms\MgHelpers;
use yii\data\ActiveDataProvider;
use yii\web\View;
use app\models\mgcms\db\Project;
use yii\widgets\ListView;

$ecProject = Project::find()->where(['status' => Project::STATUS_ACTIVE, 'type' => Project::TYPE_EC])->one();
$ecmProject = Project::find()->where(['status' => Project::STATUS_ACTIVE, 'type' => Project::TYPE_ECM])->one();

$sdtProject = new Project([
    'name' => MgHelpers::getSettingTypeText('hp sdt token name ' . Yii::$app->language,false,'hp sdt token name'),
    'file_id' => MgHelpers::getSettingTypeText('hp sdt token file id ' . Yii::$app->language,false,1128),
    'type' => Project::TYPE_SDT,
    'lead' => MgHelpers::getSettingTypeText('hp sdt token lead ' . Yii::$app->language,false,'hp sdt token lead'),
    'customLinkUrl' => \yii\helpers\Url::to(['/project/index', 'type' => Project::TYPE_SDT]),
    'useLanguage' => false
]);

?>

<div class="tokens-section section-dark-left py-5">
    <div class="section-content">
        <div class="section-title text-center"><?= Yii::t('db', 'Tokens') ?></div>

        <div class="section-background">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        <?= $this->render('/project/_tileItemEcm', ['model' => $ecmProject]); ?>
                    </div>
                    <div class="col-lg-4">
                        <?= $this->render('/project/_tileItemEcm', ['model' => $sdtProject]); ?>
                    </div>
                    <div class="col-lg-4">
                        <?= $this->render('/project/_tileItemEcm', ['model' => $ecProject]); ?>
                    </div>
                </div>

                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
</div>


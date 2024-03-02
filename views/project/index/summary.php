<?
use app\components\mgcms\MgHelpers;

?>

<div class="projects-info my-5 py-5">
    <div class="container">

        <h3><?= MgHelpers::getSettingTypeText('sdt list header 1 ' . Yii::$app->language,false,'SDT Koncepcja')?></h3>
        <?= MgHelpers::getSettingTypeText('sdt list text ' . Yii::$app->language,true,'<p>sdt list text</p>')?>

        <h3><?= MgHelpers::getSettingTypeText('sdt list header 2 ' . Yii::$app->language,false,'Portfel Energii')?></h3>
        <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="0" aria-valuemin="0"
             aria-valuemax="100">
            <div class="progress-bar" style="width: 0%"></div>
        </div>
        <p><?= Yii::t('db', 'Power sum') ?>: <strong>0 kWh</strong></p>

        <h3><?= MgHelpers::getSettingTypeText('sdt list header 3 ' . Yii::$app->language,false,'Emisja CO2')?></h3>
        <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="50" aria-valuemin="0"
             aria-valuemax="100">
            <div class="progress-bar" style="width: 0%"></div>
        </div>
        <p><?= Yii::t('db', 'Unemitted pollutants') ?>: <strong>0</strong></p>
    </div>
</div>

<?php
/* @var $this yii\web\View */


use yii\helpers\Html;
use app\components\mgcms\MgHelpers;
use \yii\helpers\Url;

$this->registerJsFile('https://cdn.veriff.me/sdk/js/1.5/veriff.min.js');
$this->registerJsFile('https://cdn.veriff.me/incontext/js/v1/veriff.js');

$this->title = Yii::t('db', 'Verify by Veriff');
$apiKey = MgHelpers::getConfigParamByPath('veriff.apiKey');
?>
<?= $this->render('/common/breadcrumps', ['displayBg' => true, 'cssClass' => 'page-header-text', ]) ?>

<div class="account-page mt-3">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-4">
                <div id='veriff-root'></div>

            </div>
            <div class="hidden mb-3" id="thankYouText">
                <h3><?= Yii::t('db', 'Thank you') ?></h3>
                <?= MgHelpers::getSettingTypeText('veriff thank you' . Yii::$app->language, true, 'Thank you for verification, please wait until verification is done') ?>
            </div>
        </div>

    </div>
</div>


<script>

</script>
<script>
    $(document).ready(function () {
        const veriff = Veriff({
            host: 'https://stationapi.veriff.com',
            apiKey: '<?= $apiKey ?>',
            parentId: 'veriff-root',
            onSession: function (err, response) {
                console.log('Session', response);
                const veriffFrame = window.veriffSDK.createVeriffFrame({
                    url: response.verification.url,
                    onEvent: function (msg) {
                        if (msg === 'FINISHED') {
                            console.log('Verification finished');
                            $('#thankYouText').removeClass('hidden');
                            $('#veriff-root').addClass('hidden');
                        }
                    }
                });
            }

        });
        veriff.setParams({
            vendorData: '<?= MgHelpers::getUserModel()->id?>'
        });
        veriff.mount();
    });

</script>

<?php
/* @var $this yii\web\View */


use yii\helpers\Html;
use app\components\mgcms\MgHelpers;
use \yii\helpers\Url;

$this->registerJsFile('https://cdn.veriff.me/sdk/js/1.5/veriff.min.js');
$this->title = Yii::t('db', 'Verify by Veriff');
?>
<?= $this->render('/common/breadcrumps') ?>

<div class="account-page mt-3">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-4">
                <div id='veriff-root' style=""></div>
            </div>
        </div>

    </div>
</div>

<script>
    $(document).ready(function () {
        const veriff = Veriff({
            apiKey: 'API_KEY',
            parentId: 'veriff-root',
            onSession: function (err, response) {
                // received the response, verification can be started / triggered now

                // redirect
                window.location.href = response.verification.url;

                // incontext sdk
                createVeriffFrame({url: response.verification.url});
            }
        });

        veriff.mount();
    });

</script>

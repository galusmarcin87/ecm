<div class="row">
    <div class="col-lg-10 ms-lg-auto">
        <div class="account-main-block">

            <div class="bg-green-right">
                <div class="bg-green-right-content">
                    <div class="row">
                        <div class="col-lg-8 mx-auto">
                            <h3 class="fw-light font-museo mb-5 text-uppercase">
                                <?= \app\components\mgcms\MgHelpers::getSettingTypeText('my account green bar header ' . Yii::$app->language, false, 'Szukasz finansowania?') ?>

                            </h3>

                            <p class="mb-4">
                                <?= \app\components\mgcms\MgHelpers::getSettingTypeText('my account green bar text ' . Yii::$app->language, false, 'my account green bar text') ?>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                            </p>

                            <a href="<?= \yii\helpers\Url::to('/site/get-capital') ?>">
                                <svg class="icon icon-long-arrow">
                                    <use xlink:href="#long-right-arrow"/>
                                </svg>
                            </a>

                        </div>
                    </div>


                </div>
            </div>

        </div>
    </div>
</div>

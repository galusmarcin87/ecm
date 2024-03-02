<?php

/* @var $model app\models\mgcms\db\Project */

/* @var $this yii\web\View */
?>

<div class="row">
    <div class="col-lg-6">

        <dl>
            <dt>Wartość:</dt>
            <dd><?= $model->money_full ?> $</dd>

            <dt>Start pre-sale:</dt>
            <dd><?= $model->date_presale_start ?></dd>

            <dt>Koniec pre-sale:</dt>
            <dd><?= $model->date_presale_end ?></dd>

            <dt>Start crowdsale:</dt>
            <dd><?= $model->date_crowdsale_start ?></dd>
        </dl>

    </div>
    <div class="col-lg-6">
        <dl>
            <dt>Koniec crowdsale:</dt>
            <dd><?= $model->date_crowdsale_end ?></dd>

            <dt>Zysk presale:</dt>
            <dd><?= $model->percentage_presale_bonus ?></dd>

            <dt>Zysk crowdsale:</dt>
            <dd><?= $model->percentage ?></dd>

            <dt>Minimal buy:</dt>
            <dd><?= $model->token_minimal_buy ?></dd>
        </dl>
    </div>
</div>

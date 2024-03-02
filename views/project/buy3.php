<?php
/* @var $model app\models\mgcms\db\Project */

/* @var $this yii\web\View */

use app\components\mgcms\MgHelpers;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\View;

/* @var $project app\models\mgcms\db\Project */
/* @var $form app\components\mgcms\yii\ActiveForm */
$this->title = Yii::t('db', 'Invest');
$model = $project;
?>

<?= $this->render('/common/breadcrumps') ?>
<style>
    table th, table th{
        padding: 20px;
    }
</style>
<section class="Section Section--big-padding-top Contact fillAccount">
    <div class="container">
        <h1 class="text-center">
            <?= Yii::t('db', 'Invest') ?>
        </h1>
        <div class="Contact__grid">

            <?php
            $form = ActiveForm::begin([
                'id' => 'login-form',
            ]);

            ?>

            <table>
                <tr>
                    <th><?= Yii::t('db', 'You invest') ?></th><td><?= number_format($amount,2,'.',' ')?> PLN </td>
                </tr>
                <tr>
                    <th><?= Yii::t('db', 'Your expected profit') ?></th><td><?= number_format($amount * ($project->percentage / 100 * (int)$model->investition_time),2,'.',' ')?> PLN </td>
                </tr>
            </table>

            <div class="row">
                <div class="col-md-12   ">
                    <input hidden name="plnToInvest3" value="<?= $amount?>"/>
                    <input
                            type="submit"
                            class="button" style="white-space: pre-wrap;" name="zonda"
                            value="<?= Yii::t('db', 'Go to Zonda Pay payment gateway to invest'); ?>"
                    />
                    <input
                            type="submit"
                            class="button" style="white-space: pre-wrap;" name="przelewy24"
                            value="<?= Yii::t('db', 'Go to Przelewy24 payment gateway to invest'); ?>"
                    />
                </div>
            </div>




            <?php ActiveForm::end(); ?>
        </div>
    </div>
</section>


<script>
  $(document).ready(function () {
    var tokenRate = <?=MgHelpers::getSetting('token rate', false, 2)?>;
    $('#tokensToInvest').on('input', function () {
      $('#plnToInvest').val($(this).val() * tokenRate);
    });
  });
</script>

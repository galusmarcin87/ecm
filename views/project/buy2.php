<?php
/* @var $project app\models\mgcms\db\Project */
/* @var $payment app\models\mgcms\db\Payment */

/* @var $this yii\web\View */

/* @var $user \app\models\mgcms\db\User */

use app\components\mgcms\MgHelpers;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\View;

/* @var $payment app\models\mgcms\db\Payment */

/* @var $form app\components\mgcms\yii\ActiveForm */

use \kartik\datecontrol\Module;

$this->title = Yii::t('db', 'Invest');
$fieldConfig = \app\components\ProjectHelper::getFormFieldConfig(true);

$buyDefaultAmount = MgHelpers::getSetting('buy default amount', false, 1000);

?>

<?= $this->render('/common/breadcrumps') ?>

<section class="Section Project">
    <?php
    $form = ActiveForm::begin([
        'id' => 'login-form',
        'fieldConfig' => $fieldConfig
    ]);

    ?>
    <div class="container">
        <h1 class="text-center"><?= Yii::t('db', 'Invest') ?></h1>
        <div class="row">
            <div class="col-md-6">
                <h4><?= $project->name ?></h4>
                <table>
                    <tr>
                        <th><?= Yii::t('db', 'Return on investment') ?> </th>
                        <td><?= $project->percentage ?>%</td>
                    </tr>
                    <tr>
                        <th><?= Yii::t('db', 'Money gathered') ?></th>
                        <td><?= $project->money ?>$</td>
                    </tr>
                    <tr>
                        <th><?= Yii::t('db', 'Goal') ?></th>
                        <td><?= $project->money_full ?>$</td>
                    </tr>
                    <tr>
                        <th><?= Yii::t('db', 'Time left') ?></th>
                        <td><?= MgHelpers::dateDifference($project->date_crowdsale_end, date("Y-m-d H:i:s"), Yii::t('db', '%a days, %h hours')) ?></td>
                    </tr>
                </table>
                <h4><?= Yii::t('db', 'Basic data') ?></h4>
                <table>
                    <tr>
                        <th><?= Yii::t('db', 'First name') ?> </th>
                        <td><?= $user->first_name ?></td>
                    </tr>
                    <tr>
                        <th><?= Yii::t('db', 'Surname') ?></th>
                        <td><?= $user->last_name ?></td>
                    </tr>
                    <tr>
                        <th><?= Yii::t('db', 'PESEL') ?></th>
                        <td><?= $user->pesel ?></td>
                    </tr>
                    <tr>
                        <th><?= Yii::t('db', 'Bank name') ?></th>
                        <td><?= $user->bank ?></td>
                    </tr>
                    <tr>
                        <th><?= Yii::t('db', 'Bank number') ?></th>
                        <td><?= $user->bank_no ?></td>
                    </tr>
                    <tr>
                        <th><?= Yii::t('db', 'Tax office') ?></th>
                        <td><?= $user->tax_office ?></td>
                    </tr>
                    <tr>
                        <th><?= Yii::t('db', 'Tax identifier') ?></th>
                        <td><?= $payment->tax_id_type ?></td>
                    </tr>
                    <tr>
                        <th><?= Yii::t('db', 'Pit transfer form') ?></th>
                        <td><?= $payment->pit_transfer_form ?></td>
                    </tr>

                </table>
                <h4><?= Yii::t('db', 'Contact data') ?></h4>
                <table>
                    <tr>
                        <th><?= Yii::t('db', 'Phone') ?> </th>
                        <td><?= $user->phone ?></td>
                    </tr>
                    <tr>
                        <th><?= Yii::t('db', 'Email') ?> </th>
                        <td><?= $user->username ?></td>
                    </tr>
                </table>
                <h4><?= Yii::t('db', 'Living address') ?></h4>
                <table>
                    <tr>
                        <th><?= Yii::t('db', 'Postcode') ?> </th>
                        <td><?= $user->postcode ?></td>
                    </tr>
                    <tr>
                        <th><?= Yii::t('db', 'City') ?> </th>
                        <td><?= $user->city ?></td>
                    </tr>
                    <tr>
                        <th><?= Yii::t('db', 'Street') ?> </th>
                        <td><?= $user->street ?></td>
                    </tr>
                    <tr>
                        <th><?= Yii::t('db', 'House no / flat no') ?> </th>
                        <td><?= $user->house_no ?>/<?= $user->flat_no ?></td>
                    </tr>
                </table>
                <h4><?= Yii::t('db', 'Corespondence address') ?></h4>
                <table>
                    <tr>
                        <th><?= Yii::t('db', 'Postcode') ?> </th>
                        <td><?= $user->cor_postcode ?></td>
                    </tr>
                    <tr>
                        <th><?= Yii::t('db', 'City') ?> </th>
                        <td><?= $user->cor_city ?></td>
                    </tr>
                    <tr>
                        <th><?= Yii::t('db', 'Street') ?> </th>
                        <td><?= $user->cor_street ?></td>
                    </tr>
                    <tr>
                        <th><?= Yii::t('db', 'House no / flat no') ?> </th>
                        <td><?= $user->cor_house_no ?>/<?= $user->cor_flat_no ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <p><?= Yii::t('db', 'Amount which you will invest') ?></p>

                <span class="amountToInvestBox">
                    <?= $payment->amount ?>
                </span>

                <div class="documents">
                    <p><?= Yii::t('db', 'Documents for acceptance') ?></p>
                    <p>
                        <a href="<?= \yii\helpers\Url::to(['/project/generate-document', 'name' => '1 - APEX - FORMULARZ POŻYCZKOWY 2023.03']) ?>">FORMULARZ
                            POŻYCZKOWY</a></p>
                    <p>
                        <a href="<?= \yii\helpers\Url::to(['/project/generate-document', 'name' => '2 - APEX DIAM - UMOWA BIZNESOWA - os. fiz. - WZÓR 2023.03']) ?>">UMOWA
                            BIZNESOWA</a></p>
                    <p>
                        <a href="<?= \yii\helpers\Url::to(['/project/generate-document', 'name' => '3 - APEX DIAM - RODO - os. fiz. - WZÓR 2023.03']) ?>">RODO</a>
                    </p>
                    <p>
                        <a href="<?= \yii\helpers\Url::to(['/project/generate-document', 'name' => '4 - APEX DIAM - PEŁNOMOC MATER - os. fiz. - WZÓR 2023.03']) ?>">PEŁNOMOC
                            MATER</a></p>
                    <p>
                        <a href="<?= \yii\helpers\Url::to(['/project/generate-document', 'name' => '5 UMOWA_ZASTAWU_rejestr_bez_dywidendy']) ?>">UMOWA
                            ZASTAWU</a></p>
                    <div><?= MgHelpers::getSettingTypeText('buy documents text ' . Yii::$app->language, true, 'buy documents text') ?></div>
                </div>

                <h4><?= Yii::t('db', 'Place and time of signing the notarial deed') ?></h4>
                <table>
                    <tr>
                        <th><?= Yii::t('db', $payment->getAttributeLabel('notarial_act_city')) ?> </th>
                        <td><?= $payment->notarial_act_city ?></td>
                    </tr>
                    <tr>
                        <th><?= Yii::t('db', $payment->getAttributeLabel('notarial_act_day')) ?> </th>
                        <td><?= $payment->notarial_act_day ?></td>
                    </tr>
                    <tr>
                        <th><?= Yii::t('db', $payment->getAttributeLabel('notarial_act_hour')) ?> </th>
                        <td><?= $payment->notarial_act_hour ?></td>
                    </tr>
                    <tr>
                        <th><?= Yii::t('db', $payment->getAttributeLabel('notarial_act_day2')) ?> </th>
                        <td><?= $payment->notarial_act_day2 ?></td>
                    </tr>
                    <tr>
                        <th><?= Yii::t('db', $payment->getAttributeLabel('notarial_act_hour2')) ?> </th>
                        <td><?= $payment->notarial_act_hour2 ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="mb-3    mt-3">
            <a class="btn btn-primary" href="javascript:history.back()"><?= Yii::t('db', 'Edit') ?></a>
        </div>
    </div>


    <?php ActiveForm::end(); ?>
</section>

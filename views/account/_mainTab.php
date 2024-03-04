<?php
/* @var $this yii\web\View */

/* @var $model \app\models\mgcms\db\User */

use app\models\mgcms\db\Project;
use app\models\mgcms\db\ProjectSearch;
use app\models\mgcms\db\User;
use kartik\grid\GridView;
use kartik\helpers\Html;
use yii\data\ActiveDataProvider;
use yii\widgets\ListView;
use app\components\mgcms\MgHelpers;

$this->title = Yii::t('db', 'My wallet');

$searchModel = new \app\models\mgcms\db\PaymentSearch();
$searchModel->user_id = MgHelpers::getUserModel()->id;
$searchModel->onlyWithHash = true;
$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
$myWallet = $model->getModelAttribute('ethAddress');
$this->registerJsFile('/js/vendor/web3.min.js');
$missingTokens = $model->getModelAttribute('missingTokens') ?? 0;
?>

<?= $this->render('/common/breadcrumps', ['displayBg' => true, 'cssClass' => 'page-header-text',]) ?>
<?= $this->render('_investor') ?>


<div class="container">


    <div class="row gx-4">

        <?= $this->render('_leftNav', ['tab' => $tab]) ?>
    </div>
</div>


<div class="container-with-background"><br><br>
    <center><h4 class="font-oswald fw-bold mb-4"><?= Yii::t('db', 'My wallet number:   ') ?> <?= $myWallet ?></h4>
    </center>

    <div class="row justify-content-center">
        <!-- Dodano 'justify-content-center' aby wyśrodkować zawartość w poziomie -->
        <div class="col-sm-2">
            <div class="mb-4"><br><br><br>
                <h4 class="font-oswald fw-bold mb-4"><?= Yii::t('db', 'Assets') ?></h4>
            </div>
            <div class="mb-1">
                <img src="/images/logo_ecm.png" alt="ECM Logo" style="height: 40px;"> ECM
            </div>
            <div class="mb-1">
                <img src="/images/logo_sdt1.png" alt="SDT1 LAB ONE Logo" style="height: 40px;"> SDT1 LAB ONE
            </div>
        </div>
        <div class="col-sm-2">
            <div class="mb-4"><br><br><br>
                <h4 class="font-oswald fw-bold mb-4"><?= Yii::t('db', 'Quantity') ?></h4>
            </div>
            <div class="mb-4">
                <p class="fw-bold bnb-value" id="ecmtokens">
                    0
                </p>
            </div>
            <div class="mb-4">
                <p class="fw-bold bnb-value" id="sdttokens">
                    0
                </p>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="mb-4"><br><br><br>
                <h4 class="font-oswald fw-bold mb-4">kW/token</h4>
            </div>
            <div class="mb-4">
                ——
            </div>
            <div class="mb-4">
                0,000108
            </div>
        </div>
        <div class="col-sm-2">
            <div class="mb-4"><br><br><br>
                <h4 class="font-oswald fw-bold mb-4">Total kW</h4>
            </div>
            <div class="mb-4">
                ——
            </div>
            <div class="mb-4">
                <p class="fw-bold bnb-value" id="totalKw">
                    0
            </div>
        </div>
        <div class="col-sm-2">
            <div class="mb-4"><br><br><br>
                <h4 class="font-oswald fw-bold mb-4"><?= Yii::t('db', 'Function') ?></h4>
            </div>
            <div class="mb-4">
                AirDrop SDTx
            </div>
            <div class="mb-4">
                AirDrop EC
            </div>
        </div>
    </div>
    <br><br>


    <div class="account-page">
        <div class="container">
            <div class="row gx-4">
                <center><h4 class="font-oswald fw-bold mb4"><?= Yii::t('db', 'Transactions history') ?></h4></center>
                <br><br>
                <?php
                $gridColumn = [
                    ['class' => 'yii\grid\SerialColumn', 'header' => 'Lp.'],
                    'project.name',
                    'created_on',
                    'amount',
                    'rate',
                    [
                        'header' => Yii::t('db', 'Transaction type'),
                        'value' => function ($model) {
                            return Yii::t('db', 'Incoming');
                        },

                    ],
                    [
                        'class' => 'kartik\grid\ExpandRowColumn',
                        'width' => '50px',
                        'header' => Yii::t('db', 'See'),
                        'value' => function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                        },
                        'detail' => function ($model, $key, $index, $column) {
                            return Yii::$app->controller->renderPartial('_expand', ['model' => $model]);
                        },
                        'headerOptions' => ['class' => 'kartik-sheet-style'],
                        'expandOneOnly' => true
                    ],
                ];
                ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $gridColumn,
                    'filterRowOptions' => ['class' => ''],
                    'pjax' => true,
                    'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-project']],
                    // your toolbar can include the additional full export menu
                ]); ?>
            </div>
        </div>
    </div>
</div>

<?

$networkUrl = MgHelpers::getSetting('eth.blockChainEndpoint', false, 'https://rpc.ankr.com/bsc_testnet_chapel');
$networkId = MgHelpers::getSetting('eth.chainId', false, '97');;

?>
<script>

    const ethConfig = {
        ECM: {
            abi: <?= MgHelpers::getSetting('eth.jsonAbi-' . 'ECM', false, '[{"inputs":[{"internalType":"string","name":"name","type":"string"},{"internalType":"string","name":"symbol","type":"string"},{"internalType":"uint256","name":"initialSupply","type":"uint256"},{"internalType":"address","name":"holder","type":"address"}],"stateMutability":"nonpayable","type":"constructor"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"owner","type":"address"},{"indexed":true,"internalType":"address","name":"spender","type":"address"},{"indexed":false,"internalType":"uint256","name":"value","type":"uint256"}],"name":"Approval","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"from","type":"address"},{"indexed":true,"internalType":"address","name":"to","type":"address"},{"indexed":false,"internalType":"uint256","name":"value","type":"uint256"}],"name":"Transfer","type":"event"},{"inputs":[{"internalType":"address","name":"owner","type":"address"},{"internalType":"address","name":"spender","type":"address"}],"name":"allowance","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"spender","type":"address"},{"internalType":"uint256","name":"amount","type":"uint256"}],"name":"approve","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"account","type":"address"}],"name":"balanceOf","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"decimals","outputs":[{"internalType":"uint8","name":"","type":"uint8"}],"stateMutability":"pure","type":"function"},{"inputs":[{"internalType":"address","name":"spender","type":"address"},{"internalType":"uint256","name":"subtractedValue","type":"uint256"}],"name":"decreaseAllowance","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"spender","type":"address"},{"internalType":"uint256","name":"addedValue","type":"uint256"}],"name":"increaseAllowance","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"nonpayable","type":"function"},{"inputs":[],"name":"name","outputs":[{"internalType":"string","name":"","type":"string"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"symbol","outputs":[{"internalType":"string","name":"","type":"string"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"totalSupply","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"to","type":"address"},{"internalType":"uint256","name":"amount","type":"uint256"}],"name":"transfer","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"from","type":"address"},{"internalType":"address","name":"to","type":"address"},{"internalType":"uint256","name":"amount","type":"uint256"}],"name":"transferFrom","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"nonpayable","type":"function"}]');?>,
            contractAddress: '<?= MgHelpers::getSetting('eth.tokenAddress-' . 'ECM', false, '0xEe108353Ef9493e0525eB8da0Dcd00caa098c62d')?>',
        },
        SDT1: {
            abi: <?= MgHelpers::getSetting('eth.jsonAbi-' . 'SDT1', false, '[{"inputs":[{"internalType":"string","name":"name","type":"string"},{"internalType":"string","name":"symbol","type":"string"},{"internalType":"uint256","name":"initialSupply","type":"uint256"},{"internalType":"address","name":"holder","type":"address"}],"stateMutability":"nonpayable","type":"constructor"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"owner","type":"address"},{"indexed":true,"internalType":"address","name":"spender","type":"address"},{"indexed":false,"internalType":"uint256","name":"value","type":"uint256"}],"name":"Approval","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"from","type":"address"},{"indexed":true,"internalType":"address","name":"to","type":"address"},{"indexed":false,"internalType":"uint256","name":"value","type":"uint256"}],"name":"Transfer","type":"event"},{"inputs":[{"internalType":"address","name":"owner","type":"address"},{"internalType":"address","name":"spender","type":"address"}],"name":"allowance","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"spender","type":"address"},{"internalType":"uint256","name":"amount","type":"uint256"}],"name":"approve","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"account","type":"address"}],"name":"balanceOf","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"decimals","outputs":[{"internalType":"uint8","name":"","type":"uint8"}],"stateMutability":"pure","type":"function"},{"inputs":[{"internalType":"address","name":"spender","type":"address"},{"internalType":"uint256","name":"subtractedValue","type":"uint256"}],"name":"decreaseAllowance","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"spender","type":"address"},{"internalType":"uint256","name":"addedValue","type":"uint256"}],"name":"increaseAllowance","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"nonpayable","type":"function"},{"inputs":[],"name":"name","outputs":[{"internalType":"string","name":"","type":"string"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"symbol","outputs":[{"internalType":"string","name":"","type":"string"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"totalSupply","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"to","type":"address"},{"internalType":"uint256","name":"amount","type":"uint256"}],"name":"transfer","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"from","type":"address"},{"internalType":"address","name":"to","type":"address"},{"internalType":"uint256","name":"amount","type":"uint256"}],"name":"transferFrom","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"nonpayable","type":"function"}]');?>,
            contractAddress: '<?= MgHelpers::getSetting('eth.tokenAddress-' . 'SDT1', false, '0xEe108353Ef9493e0525eB8da0Dcd00caa098c62d')?>',
        }

    };

    async function getBallanceOf(tokenName, walletAddress) {

        const web3 = new Web3(new Web3.providers.HttpProvider('<?= $networkUrl?>'));
        const tokenAddress = ethConfig[tokenName].contractAddress;
        const jsonABI = ethConfig[tokenName].abi;
        const contract = new web3.eth.Contract(jsonABI, tokenAddress);
        const balance = await contract.methods.balanceOf(walletAddress).call();
        return balance / 10 ** 8 + <?= $missingTokens?>;

    }

    $(document).ready(async function () {
        $('#ecmtokens').text((await getBallanceOf('ECM', '<?= $myWallet ?>')));
        const SDT1Balance = await getBallanceOf('SDT1', '<?= $myWallet ?>');
        $('#sdttokens').text(SDT1Balance);
        $('#totalKw').text(SDT1Balance * 0.000108);
    });


</script>

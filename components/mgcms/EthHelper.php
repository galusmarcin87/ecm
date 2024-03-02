<?php

namespace app\components\mgcms;

use phpseclib\Math\BigInteger;
use Web3\Contract;
use Web3\Providers\HttpProvider;
use Web3\RequestManagers\HttpRequestManager;
use Web3\Web3;
use Yii;
use app\models\mgcms\db\Setting;

/**
 * Helpers class
 * @author marcin
 */
class EthHelper extends \yii\base\Component
{


    public static function getBallanceOfToken($address, $tokenName)
    {
        $networkUrl = MgHelpers::getSetting('eth.blockChainEndpoint', false, 'https://rpc.ankr.com/bsc_testnet_chapel');
        $networkId = MgHelpers::getSetting('eth.chainId', false, '97');;
        $abi = MgHelpers::getSetting('eth.jsonAbi-' . $tokenName, false, '[{"inputs":[{"internalType":"string","name":"name","type":"string"},{"internalType":"string","name":"symbol","type":"string"},{"internalType":"uint256","name":"initialSupply","type":"uint256"},{"internalType":"address","name":"holder","type":"address"}],"stateMutability":"nonpayable","type":"constructor"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"owner","type":"address"},{"indexed":true,"internalType":"address","name":"spender","type":"address"},{"indexed":false,"internalType":"uint256","name":"value","type":"uint256"}],"name":"Approval","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"from","type":"address"},{"indexed":true,"internalType":"address","name":"to","type":"address"},{"indexed":false,"internalType":"uint256","name":"value","type":"uint256"}],"name":"Transfer","type":"event"},{"inputs":[{"internalType":"address","name":"owner","type":"address"},{"internalType":"address","name":"spender","type":"address"}],"name":"allowance","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"spender","type":"address"},{"internalType":"uint256","name":"amount","type":"uint256"}],"name":"approve","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"account","type":"address"}],"name":"balanceOf","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"decimals","outputs":[{"internalType":"uint8","name":"","type":"uint8"}],"stateMutability":"pure","type":"function"},{"inputs":[{"internalType":"address","name":"spender","type":"address"},{"internalType":"uint256","name":"subtractedValue","type":"uint256"}],"name":"decreaseAllowance","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"spender","type":"address"},{"internalType":"uint256","name":"addedValue","type":"uint256"}],"name":"increaseAllowance","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"nonpayable","type":"function"},{"inputs":[],"name":"name","outputs":[{"internalType":"string","name":"","type":"string"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"symbol","outputs":[{"internalType":"string","name":"","type":"string"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"totalSupply","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"to","type":"address"},{"internalType":"uint256","name":"amount","type":"uint256"}],"name":"transfer","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"from","type":"address"},{"internalType":"address","name":"to","type":"address"},{"internalType":"uint256","name":"amount","type":"uint256"}],"name":"transferFrom","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"nonpayable","type":"function"}]');

        $contractAddress = MgHelpers::getSetting('eth.tokenAddress-' . $tokenName, false, '0xEe108353Ef9493e0525eB8da0Dcd00caa098c62d');

        $provider = new HttpProvider(new HttpRequestManager($networkUrl, 30));
        $contract = new Contract($provider, $abi);

        $web3 = new Web3($provider);

        $functionCallData = $contract->at($contractAddress)->getData('balanceOf', $address);

        $balanceHex = $web3->eth->call([
            'to' => $contractAddress,
            'data' => $functionCallData,
        ], 'latest',function($err, $data) {
            if ($err) {
                echo $err->getMessage() . "\n";
                return;
            }

            echo '<pre>';
            echo var_dump($data);
            echo '</pre>';
            exit;
        });

        echo '<pre>';
        echo var_dump($balanceHex);
        echo '</pre>';
        exit;
        exit;
//        $contract->eth->ballanceOf($address, function ($err, $ballance) use (&$transactionCount) {
//            if ($err) {
//                echo $err->getMessage() . "\n";
//                return;
//            }
//
//            echo '<pre>';
//            echo var_dump($ballance);
//            echo '</pre>';
//            exit;
//        });
    }


}

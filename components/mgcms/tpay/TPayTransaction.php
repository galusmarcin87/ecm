<?php

namespace app\components\mgcms\tpay;

use Tpay\OriginApi\TransactionApi;
use Tpay\OriginApi\Utilities\TException;
use Tpay\OriginApi\Utilities\Util;
use Tpay\OriginApi\Notifications\BasicNotificationHandler;


class TPayTransaction extends TransactionApi
{
    private $trId;

    public function __construct($config)
    {
        $this->merchantSecret = $config['merchantSecret'];
        $this->merchantId = $config['merchantId'];
        $this->trApiKey = $config['trApiKey'];
        $this->trApiPass = $config['trApiPass'];
        Util::$loggingEnabled = true;
        Util::$customLogPatch = \Yii::getAlias('@runtime/logs/tpay.log');
        parent::__construct();
    }

    public function getTransaction()
    {
        /**
         * Get info about transaction
         */
        $transactionId = $this->trId;

        try {
            $transaction = $this->setTransactionID($transactionId)->get();
            print_r($transaction);
        } catch (TException $e) {
            var_dump($e);
        }
    }

    public function createRedirUrlForTransaction($config)
    {
        /**
         * Create new transaction
         */
        $res = $this->create($config);
        return $res['url'];

    }
}

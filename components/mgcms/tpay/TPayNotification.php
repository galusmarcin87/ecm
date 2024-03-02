<?php

namespace app\components\mgcms\tpay;

use Tpay\OriginApi\TransactionApi;
use Tpay\OriginApi\Utilities\TException;
use Tpay\OriginApi\Utilities\Util;
use Tpay\OriginApi\Notifications\BasicNotificationHandler;


class TPayNotification extends BasicNotificationHandler
{
    private $trId;

    public function __construct($config)
    {
        $this->merchantSecret = $config['merchantSecret'];
        $this->merchantId = $config['merchantId'];
        $this->trApiKey = $config['trApiKey'];
        $this->trApiPass = $config['trApiPass'];
        $this->validateServerIP = false;
        Util::$loggingEnabled = true;
        Util::$customLogPatch = \Yii::getAlias('@runtime/logs/tpay.log');
        parent::__construct();
    }

    public function getTpayNotification()
    {
        return $this->checkPayment();
    }

}

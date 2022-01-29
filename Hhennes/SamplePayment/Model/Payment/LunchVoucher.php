<?php

namespace Hhennes\SamplePayment\Model\Payment;

/**
 * Sample Offline Payment Module using old way
 * Useful tutorial : https://www.pitsolutions.ch/blog/creating-offline-payment-method-magento-2/
 */
class LunchVoucher extends \Magento\Payment\Model\Method\AbstractMethod
{
    const PAYMENT_CODE = 'lunchvoucher';

    /** @var string Payment method code */
    protected $_code = self::PAYMENT_CODE;

    /**
     * Availability option
     *
     * @var bool
     */
    protected $_isOffline = true;

}

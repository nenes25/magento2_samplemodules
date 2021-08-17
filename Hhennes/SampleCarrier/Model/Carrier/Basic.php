<?php


namespace Hhennes\SampleCarrier\Model\Carrier;


use Magento\Framework\Event\ManagerInterface;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Shipping\Model\Carrier\AbstractCarrier;
use Magento\Shipping\Model\Carrier\CarrierInterface;

/**
 * Basic Carrier with fixed price configurable in back office
 */
class Basic extends AbstractCarrier implements CarrierInterface
{

    /**
     * @var string
     */
    protected $_code = 'hhennes_basic';


    /**
     * @var bool
     */
    protected $_isFixed = true;

    /**
     * @var \Magento\Shipping\Model\Rate\ResultFactory
     */
    private $rateResultFactory;

    /**
     * @var \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory
     */
    private $rateMethodFactory;
    private ManagerInterface $eventManager;

    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory
     * @param \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory
     * @param ManagerInterface $eventManager
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory,
        \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory,
        ManagerInterface $eventManager,
        array $data = []
    )
    {
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);

        $this->rateResultFactory = $rateResultFactory;
        $this->rateMethodFactory = $rateMethodFactory;
        $this->eventManager = $eventManager;
    }

    /**
     * @inheritDoc
     */
    public function collectRates(RateRequest $request)
    {
        if (!$this->getConfigFlag('active')) {
            return false;
        }

        /** @var \Magento\Shipping\Model\Rate\Result $result */
        $result = $this->rateResultFactory->create();

        /** @var \Magento\Quote\Model\Quote\Address\RateResult\Method $method */
        $method = $this->rateMethodFactory->create();

        $method->setCarrier($this->_code);
        $method->setCarrierTitle($this->getConfigData('title'));

        $method->setMethod($this->_code);
        $method->setMethodTitle($this->getConfigData('name'));

        $shippingCost = (float)$this->getConfigData('shipping_cost');

        $method->setPrice($shippingCost);
        $method->setCost($shippingCost);

        /**
         * Good practice to add en event so external module can interact with the method
         * For example another module can hide the method in an observer by setting
         * $method->setHideMethod(true);
         * eventName 'carrier_append_method_hhennes_basic'
         */
        $this->eventManager->dispatch(
            'carrier_append_method_' . $this->_code,
            [
                'method' => $method,
                'request' => $request
            ]
        );

        if (null === $method->getHideMethod()) {
            $result->append($method);
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function isZipCodeRequired($countryId = null)
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function isCityRequired()
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function getAllowedMethods()
    {
        return [$this->_code => $this->getConfigData('name')];
    }
}

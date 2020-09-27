<?php

namespace Hhennes\CustomerAttributes\Helper;

use Magento\Customer\Model\Customer;
use Magento\Eav\Api\AttributeRepositoryInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Exception\NoSuchEntityException;

class Data extends AbstractHelper
{
    /**
     * @var AttributeRepositoryInterface
     */
    private AttributeRepositoryInterface $attributeRepository;

    /**
     * Data constructor.
     * @param Context $context
     * @param AttributeRepositoryInterface $attributeRepository
     */
    public function __construct(
        Context $context,
        AttributeRepositoryInterface $attributeRepository
    ) {
        parent::__construct($context);

        $this->attributeRepository = $attributeRepository;
    }

    /**
     * Get Select attribute options list
     * @param string $attributeCode
     * @return array
     */
    public function getSelectOptions($attributeCode)
    {
        try {
            $websiteAttribute = $this->attributeRepository->get(Customer::ENTITY, $attributeCode);
            return $websiteAttribute->getSource()->getAllOptions();
        } catch (NoSuchEntityException $e) {
            return [];
        }
    }

    /**
     * Get Customer image
     * Warning by default external access is forbidden by pub/media/customer/.htaccess
     * @param string $imagePath
     * @return string
     */
    public function getCustomerImageUrl($imagePath)
    {
        return $this->_urlBuilder->getBaseUrl('').'pub/media/customer'.$imagePath;
    }
}

<?php


namespace Hhennes\CatalogCategoryAttributes\Block;

use Magento\Framework\View\Element\Template;

class Header extends Template
{

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;
    private \Magento\Framework\Registry $registry;

    /**
     * Header constructor.
     * @param Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->registry = $registry;
    }

    /**
     * Retrieve current category model object
     *
     * @return \Magento\Catalog\Model\Category
     */
    public function getCurrentCategory()
    {
        if (!$this->hasData('current_category')) {
            $this->setData('current_category', $this->registry->registry('current_category'));
        }
        return $this->getData('current_category');
    }

    /**
     * @param string $attributeCode
     * @return mixed|string
     */
    public function getAttributeValue($attributeCode)
    {
        if ($this->getCurrentCategory()->getCustomAttribute($attributeCode)) {
            return $this->getCurrentCategory()->getCustomAttribute($attributeCode)->getValue();
        }
        return '';
    }
}

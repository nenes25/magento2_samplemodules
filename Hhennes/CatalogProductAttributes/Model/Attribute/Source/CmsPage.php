<?php

namespace Hhennes\CatalogProductAttributes\Model\Attribute\Source;

use Magento\Cms\Model\ResourceModel\Page\CollectionFactory;

/**
 * Class CmsPage
 * List all cms page for custom product attribute
 */
class CmsPage extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    private CollectionFactory $pageCollectionFactory;

    /**
     * @param CollectionFactory $pageCollectionFactory
     */
    public function __construct(CollectionFactory $pageCollectionFactory)
    {
        $this->pageCollectionFactory = $pageCollectionFactory;
    }

    /**
     * @inheritDoc
     */
    public function getAllOptions()
    {
        if (!$this->_options) {
            $this->_options = [];
            $pageCollection = $this->pageCollectionFactory->create()->load();
            //Use page_id as value as identifier is not unique
            foreach ($pageCollection as $item) {
                $this->_options[] = [
                    'value' => $item->getId(),
                    'label' => $item->getTitle()
                ];
            }
            array_unshift($this->_options, ['value' => '', 'label' => __('Please select a cms page.')]);
        }
        return $this->_options;
    }
}

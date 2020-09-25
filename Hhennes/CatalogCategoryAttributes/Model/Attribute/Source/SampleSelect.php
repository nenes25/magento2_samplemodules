<?php


namespace Hhennes\CatalogCategoryAttributes\Model\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\SourceInterface;

/**
 * Class SampleSelect
 * @package Hhennes\CatalogCategoryAttributes\Model\Attribute\Source
 * Source pour l'option sample_select_attribute cf. app/code/Hhennes/CatalogCategoryAttributes/view/adminhtml/ui_component/category_form.xml:115
 */
class SampleSelect extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{

    /**
     * @inheritDoc
     */
    public function getAllOptions()
    {
        if ($this->_options === null) {
            $this->_options = [
                ['label' => __('First value'), 'value' => 1],
                ['label' => __('Second value'), 'value' => 2],
                ['label' => __('Third value'), 'value' => 3],
            ];
        }
        return $this->_options;
    }
}

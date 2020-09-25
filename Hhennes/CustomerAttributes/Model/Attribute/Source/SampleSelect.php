<?php


namespace Hhennes\CustomerAttributes\Model\Attribute\Source;


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

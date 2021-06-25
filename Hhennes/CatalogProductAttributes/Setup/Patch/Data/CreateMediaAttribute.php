<?php

namespace Hhennes\CatalogProductAttributes\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Eav\Setup\EavSetupFactory;

/**
 * Class CreateMediaAttribute
 * Create A Media Image Attribute
 * @package Hhennes\CatalogProductAttributes\Setup\Patch\Data
 */
class CreateMediaAttribute implements DataPatchInterface
{

    /**
     * @var EavSetupFactory
     */
    private EavSetupFactory $eavSetupFactory;

    /**
     * CreateMediaAttribute constructor.
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * @inheritDoc
     */
    public function apply()
    {
        $eavSetup = $this->eavSetupFactory->create();
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'hover_image',
            [
                'type' => 'varchar',
                'label' => 'Hover Image',
                'input' => 'media_image',
                'required' => false,
                'sort_order' => 30,
                'frontend' => \Magento\Catalog\Model\Product\Attribute\Frontend\Image::class,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'used_in_product_listing' => true,
                'user_defined' => true,
                'visible' => true,
                'visible_on_front' => true
            ]
        );
        $id = $eavSetup->getAttributeId(
            \Magento\Catalog\Model\Product::ENTITY,
            'hover_image'
        );
        $attributeSetIds = $eavSetup->getAllAttributeSetIds(\Magento\Catalog\Model\Product::ENTITY);
        foreach ( $attributeSetIds as $attributeSetId) {
            $eavSetup->addAttributeToGroup(\Magento\Catalog\Model\Product::ENTITY, $attributeSetId, 'image-management', $id, 10);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getAliases()
    {
        return [];
    }
}

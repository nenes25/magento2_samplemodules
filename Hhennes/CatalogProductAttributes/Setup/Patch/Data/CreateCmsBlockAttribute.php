<?php

namespace Hhennes\CatalogProductAttributes\Setup\Patch\Data;

use Magento\Catalog\Model\Product;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Eav\Setup\EavSetupFactory;

/**
 * Create a product attribute select with cms block values
 */
class CreateCmsBlockAttribute implements DataPatchInterface
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
        $attributeSetIds = $eavSetup->getAllAttributeSetIds(Product::ENTITY);
        //Details product
        $eavSetup->addAttribute(
            Product::ENTITY,
            'related_cms_block',
            [
                'type' => 'int',
                'label' => 'Related cms block',
                'input' => 'select',
                'source' => \Magento\Catalog\Model\ResourceModel\Category\Attribute\Source\Page::class, //Use existing magento source
                'required' => false,
                'sort_order' => 41,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'used_in_product_listing' => false,
                'user_defined' => true,
                'visible' => true,
                'visible_on_front' => true
            ]
        );
        $idPage = $eavSetup->getAttributeId(
            Product::ENTITY,
            'related_cms_block'
        );

        foreach ($attributeSetIds as $attributeSetId) {
            $eavSetup->addAttributeToGroup(Product::ENTITY, $attributeSetId, 'product-details', $idPage, 45);
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

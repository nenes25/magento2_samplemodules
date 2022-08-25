<?php


namespace Hhennes\CatalogProductAttributes\Setup\Patch\Data;

use Magento\Catalog\Model\Product;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Eav\Setup\EavSetupFactory;

/**
 * Create a product attribute select with cms block values
 */
class CreateCmsPageAttribute implements DataPatchInterface
{

    /**
     * @var EavSetupFactory
     */
    private EavSetupFactory $eavSetupFactory;

    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * @inheritDoc
     */
    public function apply()
    {
        /** @var \Magento\Eav\Setup\EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create();
        $attributeSetIds = $eavSetup->getAllAttributeSetIds(Product::ENTITY);
        //Details product
        $eavSetup->addAttribute(
            Product::ENTITY,
            'related_cms_page',
            [
                'type' => 'int',
                'label' => 'Related cms page',
                'input' => 'select',
                'source' => \Hhennes\CatalogProductAttributes\Model\Attribute\Source\CmsPage::class, //Use custom model to get available cms pages
                'required' => false,
                'sort_order' => 40,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'used_in_product_listing' => false,
                'user_defined' => true,
                'visible' => true,
                'visible_on_front' => true
            ]
        );
        $idPage = $eavSetup->getAttributeId(
            Product::ENTITY,
            'related_cms_page'
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

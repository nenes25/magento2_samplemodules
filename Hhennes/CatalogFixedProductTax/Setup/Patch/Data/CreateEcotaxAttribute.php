<?php


namespace Hhennes\CatalogFixedProductTax\Setup\Patch\Data;

use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Eav\Setup\EavSetupFactory;

class CreateEcotaxAttribute implements DataPatchInterface
{
    /** @var string Nom de l'attribut à créer */
    const ATTRIBUTE_CODE = 'ecotaxe';

    /** @var EavSetupFactory */
    private EavSetupFactory $eavSetupFactory;

    /**
     * CreateYesNoAttribute constructor.
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
            Product::ENTITY,
            self::ATTRIBUTE_CODE,
            [
                'type' => 'static',
                'label' => 'Ecotax',
                'input' => 'weee',
                'backend' => \Magento\Weee\Model\Attribute\Backend\Weee\Tax::class,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'required' => false,
                'sort_order' => 50,
                'user_defined' => true,
            ]
        );
        $id = $eavSetup->getAttributeId(
            Product::ENTITY,
            self::ATTRIBUTE_CODE
        );

        $attributeSetIds = $eavSetup->getAllAttributeSetIds(Product::ENTITY);
        foreach ($attributeSetIds as $attributeSetId) {
            $eavSetup->addAttributeToGroup(Product::ENTITY, $attributeSetId, 'advanced-pricing', $id, 30);
        }
    }

    /**
     * @inheritDoc
     */
    public static function getDependencies()
    {
        return [ ConfigureFixedProductTax::class ];
    }

    /**
     * @inheritDoc
     */
    public function getAliases()
    {
        return [];
    }
}

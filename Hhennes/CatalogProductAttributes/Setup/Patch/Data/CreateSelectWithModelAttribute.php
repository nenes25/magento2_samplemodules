<?php


namespace Hhennes\CatalogProductAttributes\Setup\Patch\Data;


use Hhennes\CatalogProductAttributes\Model\Attribute\Source\SampleSelect;
use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\Patch\DataPatchInterface;


class CreateSelectWithModelAttribute implements DataPatchInterface
{
    /** @var string Nom de l'attribut à créer */
    const ATTRIBUTE_CODE = 'sample_select_model';

    /** @var EavSetupFactory */
    private $eavSetupFactory;

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
                'type' => 'int',
                'label' => 'Sample Select',
                'input' => 'select',
                'required' => false,
                'sort_order' => 70,
                'source' => SampleSelect::class,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'used_in_product_listing' => true,
                'user_defined' => true,
                'visible' => true,
                'visible_on_front' => true,
                'searchable' => false,
                'filterable' => true,
                'comparable' => true,
                'unique' => false,
                'default' => 0,
            ]
        );
        $id = $eavSetup->getAttributeId(
            Product::ENTITY,
            self::ATTRIBUTE_CODE
        );

        $attributeSetIds = $eavSetup->getAllAttributeSetIds(Product::ENTITY);
        foreach ($attributeSetIds as $attributeSetId) {
            $eavSetup->addAttributeToGroup(Product::ENTITY, $attributeSetId, 'product-details', $id, 10);
        }
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

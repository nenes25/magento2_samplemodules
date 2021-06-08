<?php


namespace Hhennes\CatalogProductAttributes\Setup\Patch\Data;


use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Model\Entity\Attribute\Source\Table;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Eav\Model\Config;

class CreateSelectAttribute implements DataPatchInterface
{
    /** @var string Nom de l'attribut à créer */
    const ATTRIBUTE_CODE = 'sample_select';

    /** @var EavSetupFactory */
    private $eavSetupFactory;
    private Config $config;

    /**
     * CreateYesNoAttribute constructor.
     * @param EavSetupFactory $eavSetupFactory
     * @param Config $config
     */
    public function __construct(
        EavSetupFactory $eavSetupFactory,
        Config $config
    )
    {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->config = $config;
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
                'sort_order' => 60,
                'source' => Table::class,
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
        $this->initOptions();
    }

    /**
     * Initialize select Options values
     */
    protected function initOptions()
    {
        $attribute = $this->config->getAttribute(Product::ENTITY, self::ATTRIBUTE_CODE);
        if (!$attribute) {
            return;
        }

        $attributeData=[];
        //Formated options
        $attributeData['option'] = [
                'order' => [
                    'option_0' => 0,
                    'option_1' => 1,
                    'option_2' => 2,
                ],
                'value' => [
                    'option_0' => [0 => 'option 0', 1 => ''],//Label per stores
                    'option_1' => [0 => 'option 1', 1 => ''],
                    'option_2' => [0 => 'option 2', 1 => ''],
                ]
        ];
        $attribute->addData($attributeData);
        $attribute->save();
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

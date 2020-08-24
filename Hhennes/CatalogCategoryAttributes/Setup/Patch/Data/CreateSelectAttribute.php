<?php

namespace Hhennes\CatalogCategoryAttributes\Setup\Patch\Data;

use Magento\Catalog\Model\Category;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class CreateSelectAttribute implements DataPatchInterface
{

    /** @var string Nom de l'attribut à créer */
    const ATTRIBUTE_CODE = 'sample_select_attribute';

    /** @var EavSetupFactory  */
    private $eavSetupFactory;

    /**
     * CreateSelectAttribute constructor.
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
            Category::ENTITY,
            self::ATTRIBUTE_CODE,
            [
                'type'         => 'int',
                'label'        => 'Sample Select Attribute',
                'input'        => 'select',
                'sort_order'   => 102,
                'source'       => \Hhennes\CatalogCategoryAttributes\Model\Attribute\Source\SampleSelect::class,
                'global'       => \Magento\Catalog\Model\ResourceModel\Eav\Attribute::SCOPE_STORE,
                'visible'      => true,
                'required'     => false,
                'user_defined' => false,
                'group'        => '',
                'backend'      => '',
                'default' => 0,
            ]
        );

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

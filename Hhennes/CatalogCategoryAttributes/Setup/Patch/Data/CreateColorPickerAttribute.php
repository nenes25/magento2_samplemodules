<?php

namespace Hhennes\CatalogCategoryAttributes\Setup\Patch\Data;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class CreateColorPickerAttribute implements DataPatchInterface
{

    /** @var string Nom de l'attribut à créer */
    const ATTRIBUTE_CODE = 'sample_colorpicker_attribute';

    /** @var EavSetupFactory  */
    private $eavSetupFactory;

    /**
     * CreateColorPickerAttribute constructor.
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
        /**
         * En complément de la création de l'attribut il faut penser à le définir dans l'ui_component
         * Dans le cas du colorpicker , c'est uniquement l'ui_component qui fait la différence avec un attribut texte simple
         * sinon il ne s'affiche pas en back office
         */
        $eavSetup = $this->eavSetupFactory->create();

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            self::ATTRIBUTE_CODE,
            [
                'type'         => 'varchar',
                'label'        => 'ColorPicker Attribute',
                'input'        => 'text',
                'sort_order'   => 103,
                'source'       => '',
                'global'       => \Magento\Catalog\Model\ResourceModel\Eav\Attribute::SCOPE_GLOBAL,
                'visible'      => true,
                'required'     => false,
                'user_defined' => false,
                'default'      => null,
                'group'        => '',
                'backend'      => ''
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

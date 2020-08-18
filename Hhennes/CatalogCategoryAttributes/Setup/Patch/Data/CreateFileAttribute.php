<?php


namespace Hhennes\CatalogCategoryAttributes\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\Patch\PatchInterface;


class CreateFileAttribute implements DataPatchInterface
{

    /** @var string Nom de l'attribut à créer */
    const ATTRIBUTE_CODE = 'sample_file_attribute';

    private $eavSetupFactory;

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
         * Dans le cas de d'un file , c'est un peu plus complexe à gérer
         * Il faut faire un ui_component + gérer l'upload
         * sinon il ne s'affiche pas en back office
         */
        $eavSetup = $this->eavSetupFactory->create();

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            self::ATTRIBUTE_CODE,
            [
                'type' => 'varchar',
                'label' => 'File Attribute',
                'input' => 'text',
                'sort_order' => 105,
                'source' => '',
                'global' => \Magento\Catalog\Model\ResourceModel\Eav\Attribute::SCOPE_GLOBAL,
                'visible' => true,
                'required' => false,
                'user_defined' => false,
                'default' => null,
                'group' => '',
                'backend' => ''
            ]
        );
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

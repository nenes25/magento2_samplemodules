<?php
namespace Hhennes\CatalogCategoryAttributes\Setup\Patch\Data;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

/**
 * Create an editor Attribute
 * Specific parameters are necessary in view/adminhtml/ui_component/category_form.xml
 */
class CreateEditorAttribute implements DataPatchInterface
{

    /** @var string Nom de l'attribut à créer */
    const ATTRIBUTE_CODE = 'sample_editor_attribute';

    /** @var EavSetupFactory */
    private $eavSetupFactory;

    /**
     * CreateTextAttribute constructor.
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
            \Magento\Catalog\Model\Category::ENTITY,
            self::ATTRIBUTE_CODE,
            [
                'type' => 'text',
                'label' => 'Sample editor attribute',
                'input' => 'textarea',
                'sort_order' => 107,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'visible' => true,
                'required' => false,
                'user_defined' => false,
                'default' => null,
                'wysiwyg_enabled' => true,
                'is_html_allowed_on_front' => true,
                'is_pagebuilder_enabled' => true, //For EE or 2.4.3+
                'group' => 'General Information',
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

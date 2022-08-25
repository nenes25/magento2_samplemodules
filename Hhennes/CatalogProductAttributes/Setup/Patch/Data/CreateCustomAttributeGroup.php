<?php
/**
 * Hervé HENNES
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * Available through the world-wide-web at this URL:
 * https://opensource.org/licenses/afl-3.0.php
 *
 * @author    Hervé HENNES <contact@h-hhennes.fr>
 * @copyright since 2022 Hervé HENNES
 * @license   https://opensource.org/licenses/AFL-3.0  Academic Free License ("AFL") v. 3.0
 */

namespace Hhennes\CatalogProductAttributes\Setup\Patch\Data;

use Magento\Catalog\Model\Product;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Eav\Setup\EavSetupFactory;

class CreateCustomAttributeGroup implements DataPatchInterface
{

    /**
     * @var EavSetupFactory
     */
    private EavSetupFactory $eavSetupFactory;

    /**
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
        /** @var \Magento\Eav\Setup\EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create();
        $attributeSetIds = $eavSetup->getAllAttributeSetIds(Product::ENTITY);
        $attributeGroupName = 'Hhennes Attributes';
        $attributeGroupCode = $eavSetup->convertToAttributeGroupCode($attributeGroupName);

        foreach ($attributeSetIds as $attributeSetId) {
            $eavSetup->addAttributeGroup(Product::ENTITY, $attributeSetId, $attributeGroupName, 300);
        }

        //If we want to add attribute to this group
        /*$attributesCodes = ['attribute_code'];
        foreach ($attributesCodes as $attributesCode) {
            foreach ($attributeSetIds as $attributeSetId) {
                $attributeId = $eavSetup->getAttributeId(Product::ENTITY,$attributesCode);
                if ( $attributeId) {
                    $eavSetup->addAttributeToGroup(
                        Product::ENTITY,
                        $attributeSetId,
                        $attributeGroupCode,
                        $attributesCode,
                        110
                    );
                }
            }
        }*/

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

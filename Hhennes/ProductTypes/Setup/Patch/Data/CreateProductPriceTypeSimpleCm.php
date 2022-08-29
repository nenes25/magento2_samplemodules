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

namespace Hhennes\ProductTypes\Setup\Patch\Data;

use Magento\Catalog\Model\Product;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class CreateProductPriceTypeSimpleCm implements DataPatchInterface
{

    /** @var string Product type code */
    public const PRODUCT_TYPE_CODE = 'simplecm';

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
     * In order to make the new product type working we need to add the type to all needed
     * attributes by updating the field apply_to of the table catalog_product_eav_attribute
     * @return CreateProductPriceTypeSimpleCm|void
     */
    public function apply()
    {
        /** @var  \Magento\Eav\Setup\EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create();
        $fieldList = [
            'price',
            'special_from_date',
            'special_to_date',
            'cost',
            'tier_price',
            'weight',
        ];
        $newType = self::PRODUCT_TYPE_CODE;
        foreach ($fieldList as $field) {
            $applyTo = explode(
                ',',
                $eavSetup->getAttribute(Product::ENTITY, $field, 'apply_to')
            );
            if (!in_array($newType, $applyTo)) {
                $applyTo[] = $newType;
                $eavSetup->updateAttribute(
                    Product::ENTITY,
                    $field,
                    'apply_to',
                    implode(',', $applyTo)
                );
            }
        }
    }

    /**
     * @inheritdoc
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function getAliases()
    {
        return [];
    }
}

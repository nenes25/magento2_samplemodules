<?php
/**
 * 2002-2020 ADVISA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0) that is available
 * through the world-wide-web at this URL: http://www.opensource.org/licenses/OSL-3.0
 * If you are unable to obtain it through the world-wide-web, please send an email
 * to mage@advisa.fr so we can send you a copy immediately.
 *
 * @author ADVISA
 * @copyright 2002-2020 ADVISA
 * @license http://www.opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

namespace Hhennes\CustomerAttributes\Setup\Patch\Data;

use Magento\Customer\Model\Customer;
use Magento\Eav\Model\Entity\Attribute\Source\Boolean;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class CreateYesNoAttribute implements DataPatchInterface
{

    /** @var string Nom du champ de flag qui sera ajouté dans toutes les tables */
    const ATTRIBUTE_CODE = 'sample_yes_no_attribute';

    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;
    /**
     * @var CustomerSetupFactory
     */
    private $customerSetupFactory;
    /**
     * @var AttributeSetFactory
     */
    private $attributeSetFactory;

    /**
     * CreateExportFlags constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param CustomerSetupFactory $customerSetupFactory
     * @param AttributeSetFactory $attributeSetFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CustomerSetupFactory $customerSetupFactory,
        AttributeSetFactory $attributeSetFactory
    )
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
    }

    /**
     * @inheritDoc
     */
    public function apply()
    {
        /** @var  \Magento\Eav\Setup\EavSetup $eavSetup */
        $eavSetup = $this->customerSetupFactory->create();
        $eavSetup->addAttribute(
            Customer::ENTITY,
            self::ATTRIBUTE_CODE,
            [
                'type' => 'int',
                'label' => 'Sample Attribute Yes No',
                'input' => 'select',
                'source' => Boolean::class,
                'required' => false,
                'visible' => true,
                'user_defined' => false,
                'position' => 101,
                'system' => 0,
            ]
        );

        $customerEntity = $eavSetup->getEavConfig()->getEntityType(Customer::ENTITY);
        $attributeSetId = $customerEntity->getDefaultAttributeSetId();
        $attributeSet = $this->attributeSetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);

        $sampleAttribute = $eavSetup->getEavConfig()->getAttribute(Customer::ENTITY, self::ATTRIBUTE_CODE);
        $sampleAttribute->addData([
            'attribute_set_id' => $attributeSetId,
            'attribute_group_id' => $attributeGroupId,
            'used_in_forms', ['adminhtml_customer'] //possibles values : adminhtml_checkout,adminhtml_customer,adminhtml_customer_address,customer_account_edit,customer_address_edit,customer_register_address
        ]);

        $sampleAttribute->save();
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

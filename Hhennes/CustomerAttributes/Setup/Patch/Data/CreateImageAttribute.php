<?php

namespace Hhennes\CustomerAttributes\Setup\Patch\Data;

use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Serialize\SerializerInterface;

/**
 * Class CreateImageAttribute
 * Same as file but with format restrictions
 * @package Hhennes\CustomerAttributes\Setup\Patch\Data
 */
class CreateImageAttribute implements DataPatchInterface
{

    /** @var string Code de l'attribut */
    const ATTRIBUTE_CODE = 'sample_image_attribute';

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
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * CreateExportFlags constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param CustomerSetupFactory $customerSetupFactory
     * @param AttributeSetFactory $attributeSetFactory
     * @param SerializerInterface $serializer
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CustomerSetupFactory $customerSetupFactory,
        AttributeSetFactory $attributeSetFactory,
        SerializerInterface $serializer
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
        $this->serializer = $serializer;
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
                'type' => 'varchar',
                'label' => 'Sample Attribute Image',
                'input' => 'file',
                'required' => false,
                'visible' => true,
                'user_defined' => true,
                'position' => 105,
                'system' => 0,
                'validate_rules' => $this->serializer->serialize(['max_file_size' => 1048576, 'file_extensions' => 'jpg'])
            ]
        );

        $attributeSetId = $eavSetup->getDefaultAttributeSetId(Customer::ENTITY);
        $attributeGroupId = $eavSetup->getDefaultAttributeGroupId(Customer::ENTITY);

        $sampleAttribute = $eavSetup->getEavConfig()->getAttribute(Customer::ENTITY, self::ATTRIBUTE_CODE);
        $sampleAttribute->addData([
            'attribute_set_id' => $attributeSetId,
            'attribute_group_id' => $attributeGroupId,
            'used_in_forms' => ['adminhtml_customer', 'customer_account_create', 'customer_account_edit'] //possibles values : adminhtml_checkout,adminhtml_customer,adminhtml_customer_address,customer_account_edit,customer_address_edit,customer_register_address
        ]);

        $sampleAttribute->save();

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

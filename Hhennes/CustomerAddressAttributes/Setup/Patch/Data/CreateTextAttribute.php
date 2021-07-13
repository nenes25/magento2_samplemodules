<?php


namespace Hhennes\CustomerAddressAttributes\Setup\Patch\Data;


use Exception;
use Magento\Eav\Model\Config;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class CreateTextAttribute implements DataPatchInterface
{

    /** @var string Nom de l'attribut à créer */
    const ATTRIBUTE_CODE = 'sample_text_attribute';

    /**
     * @var Config
     */
    private $eavConfig;

    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * AddressAttribute constructor.
     *
     * @param Config $eavConfig
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        Config $eavConfig,
        EavSetupFactory $eavSetupFactory
    )
    {
        $this->eavConfig = $eavConfig;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        try {
            $eavSetup = $this->eavSetupFactory->create();
            $eavSetup->addAttribute('customer_address', self::ATTRIBUTE_CODE, [
                'type' => 'varchar',
                'input' => 'text',
                'label' => 'Sample text attribute',
                'visible' => true,
                'required' => false,
                'user_defined' => true,
                'system' => false,
                'group' => 'General',
                'global' => true,
                'visible_on_front' => true,
            ]);

            $attribute = $this->eavConfig->getAttribute('customer_address', self::ATTRIBUTE_CODE);
            $attribute->setData(
                'used_in_forms',
                [
                    'adminhtml_customer_address',
                    'customer_address_edit',
                    'customer_register_address'
                ]
            );
            $attribute->save();
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases(): array
    {
        return [];
    }
}

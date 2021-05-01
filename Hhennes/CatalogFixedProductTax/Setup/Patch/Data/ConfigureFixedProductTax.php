<?php

namespace Hhennes\CatalogFixedProductTax\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Magento\Framework\App\Config\Storage\WriterInterface;

class ConfigureFixedProductTax implements DataPatchInterface, PatchRevertableInterface
{

    /** @var string Configuration path to enable wee */
    const CONFIG_PATH_ENABLE_FPT = 'tax/weee/enable';
    /** @var int Value to enable */
    const VALUE_ENABLE = 1;
    /** @var int Value to disable */
    const VALUE_DISABLE = 0;

    /**
     * @var WriterInterface
     */
    private WriterInterface $writer;

    /**
     * ConfigureFixedProductTax constructor.
     * @param WriterInterface $writer
     */
    public function __construct(
        WriterInterface $writer
    ) {
        $this->writer = $writer;
    }

    /**
     * @inheritDoc
     */
    public function apply()
    {
        $this->writer->save(self::CONFIG_PATH_ENABLE_FPT, self::VALUE_ENABLE);
    }

    /**
     * @inheritDoc
     */
    public function revert()
    {
        $this->writer->save(self::CONFIG_PATH_ENABLE_FPT, self::VALUE_DISABLE);
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

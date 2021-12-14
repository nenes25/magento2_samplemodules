<?php
/**
 * Hervé HENNES
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file docs/licenses/LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to contact@h-hennes.fr so we can send you a copy immediately.
 *
 * @author    Hervé HENNES <contact@h-hhennes.fr>
 * @copyright since 2021 Hervé HENNES
 * @license   https://opensource.org/licenses/AFL-3.0  Academic Free License ("AFL") v. 3.0
 */

namespace Hhennes\CustomerPhoneValidation\Plugin\Magento\Customer\Helper;

use Magento\Customer\Helper\Address;

class AddressPlugin
{

    /** @var string Magento customer address "telephone" attribute code */
    const ATTRIBUTE_CODE_PHONE = 'telephone';

    /** @var string javascript custom validation class */
    const PHONE_VALIDATION_CLASS = 'validate-custom-phone';

    /**
     * Add a custom validation rule for "telephone" attribute code
     *
     * @param Address $subject
     * @param string $result
     * @param string $attributeCode
     * @return string
     */
    public function afterGetAttributeValidationClass(Address $subject, string $result, $attributeCode): string
    {
        if ($attributeCode == self::ATTRIBUTE_CODE_PHONE) {
            $result .= " " . self::PHONE_VALIDATION_CLASS;
        }
        return $result;
    }
}

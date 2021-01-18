<?php

namespace Hhennes\CustomerExtensionAttributes\Plugin;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Api\ExtensionAttributesFactory;
use Magento\Framework\App\ResourceConnection;

/**
 * Class CustomerRepositoryPlugin
 * @package Hhennes\CustomerExtensionAttributes\Plugin
 *
 * Plugin de démo , les récupération d'informations sont effectuée via des requêtes sql directes
 * Ce n'est pas la bonne méthode il faut créé son propre objet
 */
class CustomerRepositoryPlugin
{
    /** @var string Nom de la table du module */
    const TABLE_NAME = 'hhennes_customer_extensionattributes';

    /**
     * @var ExtensionAttributesFactory
     */
    private ExtensionAttributesFactory $extensionAttributesFactory;
    /**
     * @var ResourceConnection
     */
    private ResourceConnection $connection;

    /**
     * CustomerRepositoryPlugin constructor.
     * @param ExtensionAttributesFactory $extensionAttributesFactory
     * @param ResourceConnection $connection
     */
    public function __construct(
        ExtensionAttributesFactory $extensionAttributesFactory,
        ResourceConnection $connection
    )
    {
        $this->extensionAttributesFactory = $extensionAttributesFactory;
        $this->connection = $connection;
    }

    /**
     * Après la sauvegarde d'un client on rajoute les champs customs ( sans logique particulière pour l'instant )
     * @param CustomerRepositoryInterface $subject
     * @param CustomerInterface $result
     * @param CustomerInterface $customer
     * @param string $passwordHash
     * @return CustomerInterface
     */
    public function afterSave(CustomerRepositoryInterface $subject, CustomerInterface $result, CustomerInterface $customer, $passwordHash)
    {
        $this->updateCustomerExtensions($result->getId());
        return $result;
    }

    /**
     * @param CustomerRepositoryInterface $subject
     * @param CustomerInterface $customer
     * @param int $customerId
     * @return CustomerInterface
     */
    public function afterGetById(CustomerRepositoryInterface $subject, CustomerInterface $customer, int $customerId)
    {
        $extensionAttributes = $customer->getExtensionAttributes();
        $extensionAttributes = $extensionAttributes ? $extensionAttributes : $this->extensionFactory->create();

        $attributes = $this->getCustomerExtensionFields($customerId);
        if (array_key_exists('customer_code', $attributes)) {
            $extensionAttributes->setCustomerCode($attributes['customer_code']);
        }
        if (array_key_exists('customer_enterprise_code', $attributes)) {
            $extensionAttributes->setCustomerEnterpriseCode($attributes['customer_enterprise_code']);
        }
        $customer->setExtensionAttributes($extensionAttributes);

        return $customer;
    }

    /**
     * @param CustomerRepositoryInterface $subject
     * @param bool $result
     * @param CustomerInterface $customer
     * @return bool
     */
    public function afterDelete(CustomerRepositoryInterface $subject, bool $result, CustomerInterface $customer)
    {
        $this->deleteCustomerExtensions($customer->getId());
        return $result;
    }

    /**
     * @param CustomerRepositoryInterface $subject
     * @param bool $result
     * @param int $customerId
     * @return bool
     */
    public function afterDeleteById(CustomerRepositoryInterface $subject, bool $result, int $customerId)
    {
        $this->deleteCustomerExtensions($customerId);
        return $result;
    }

    /**
     * Création ou mise à jour des informations du client
     * @param int $customerId
     */
    private function updateCustomerExtensions(int $customerId): void
    {
        //On part du principe que les informations ne doivent etre intégrée qu'une seule fois.
        if (!count($this->getCustomerExtensionFields($customerId))) {
            $write = $this->connection->getConnection();
            $write->insertArray(
                $write->getTableName(self::TABLE_NAME),
                [
                    'customer_id', 'customer_code', 'customer_enterprise_code'
                ],
                [
                    [
                        $customerId, 'code_' . date('YmdHis'), 'enterprise_' . date('YmdHis')
                    ]
                ]
            );
        }
    }

    /**
     * Suppression des informations du client
     * @param int $customerId
     */
    private function deleteCustomerExtensions(int $customerId): void
    {
        $read = $this->connection->getConnection();
        $read->delete(
            $read->getTableName('hhennes_customer_extensionattributes'),
            'customer_id = ' . $customerId
        );
    }

    /**
     * Récupération des extensions spécifiques
     * @param int $customerId
     * @return array
     */
    private function getCustomerExtensionFields(int $customerId): array
    {
        $read = $this->connection->getConnection();
        $results = $read->fetchRow(
            $read->select()
                ->from($read->getTableName(self::TABLE_NAME))
                ->where('customer_id = ?', $customerId)
        );

        if (false === $results) {
            return [];
        }

        return $results;
    }
}

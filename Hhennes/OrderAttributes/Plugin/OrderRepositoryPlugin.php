<?php

namespace Hhennes\OrderAttributes\Plugin;

use Magento\Sales\Api\Data\OrderExtensionFactory;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderSearchResultInterface;
use Magento\Sales\Api\OrderRepositoryInterface;

class OrderRepositoryPlugin
{

    /**
     * @var OrderExtensionFactory
     */
    protected $extensionFactory;

    /**
     * OrderRepositoryPlugin constructor.
     * @param OrderExtensionFactory $extensionFactory
     */
    public function __construct(OrderExtensionFactory $extensionFactory)
    {
        $this->extensionFactory = $extensionFactory;
    }

    /**
     * On ajoute tout les champs customs après le chargement d'une commande
     *
     * @param OrderRepositoryInterface $subject
     * @param OrderInterface $order
     * @return OrderInterface
     */
    public function afterGet(OrderRepositoryInterface $subject, OrderInterface $order)
    {

        //Récupération de l'instance des Extensions
        $extensionAttributes = $order->getExtensionAttributes();
        $extensionAttributes = $extensionAttributes ? $extensionAttributes : $this->extensionFactory->create();

        //Récupération des valeurs de nos champs customs
        $sampleBoolean = $order->getData('sample_boolean_attribute');
        $sampleInt = $order->getData('sample_int_attribute');
        $sampleText = $order->getData('sample_text_attribute');

        //Définitions des valeurs dans les extensions attributes
        $extensionAttributes->setSampleBooleanAttribute($sampleBoolean);
        $extensionAttributes->setSampleIntAttribute($sampleInt);
        $extensionAttributes->setSampleTextAttribute($sampleText);

        //Renvoi des extensions attributes
        $order->setExtensionAttributes($extensionAttributes);

        return $order;
    }

    /**
     * On ajoute tout les champs customs après la récupération d'une liste
     *
     * @param OrderRepositoryInterface $subject
     * @param OrderSearchResultInterface $searchResult
     * @return OrderSearchResultInterface
     */
    public function afterGetList(OrderRepositoryInterface $subject, OrderSearchResultInterface $searchResult)
    {
        $orders = $searchResult->getItems();

        foreach ($orders as &$order) {

            //Récupération de l'instance des Extensions
            $extensionAttributes = $order->getExtensionAttributes();
            $extensionAttributes = $extensionAttributes ? $extensionAttributes : $this->extensionFactory->create();

            //Récupération des valeurs de nos champs customs
            $sampleBoolean = $order->getData('sample_boolean_attribute');
            $sampleInt = $order->getData('sample_int_attribute');
            $sampleText = $order->getData('sample_text_attribute');

            //Définitions des valeurs dans les extensions attributes
            $extensionAttributes->setSampleBooleanAttribute($sampleBoolean);
            $extensionAttributes->setSampleIntAttribute($sampleInt);
            $extensionAttributes->setSampleTextAttribute($sampleText);

            //Renvoi des extensions attributes
            $order->setExtensionAttributes($extensionAttributes);
        }

        return $searchResult;
    }
}

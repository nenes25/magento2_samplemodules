<?php

namespace Hhennes\OrderAttributes\Controller\Test;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Sales\Api\OrderRepositoryInterface;

/**
 * Class Index
 * Controller de test pour vérifier le bon fonctionnement des extensions attributes
 * @package Hhennes\OrderAttributes\Controller\Test
 */
class Index extends Action
{
    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * Index constructor.
     * @param Context $context
     * @param OrderRepositoryInterface $orderRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        Context $context,
        OrderRepositoryInterface $orderRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        parent::__construct($context);
        $this->orderRepository = $orderRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $criteria = $this->searchCriteriaBuilder->create();
        $orders = $this->orderRepository->getList($criteria);
        /** @var  \Magento\Sales\Api\Data\OrderInterface $order */
        foreach ($orders as $order) {
            echo "Sample Boolean Attribute for order " . $order->getIncrementId() . " : "
                . $order->getExtensionAttributes()->getSampleBooleanAttribute() . "<br />";
            echo "Sample Int Attribute for order " . $order->getIncrementId() . " : "
                . $order->getExtensionAttributes()->getSampleIntAttribute() . "<br />";
            echo "Sample Text Attribute for order " . $order->getIncrementId() . " : "
                . $order->getExtensionAttributes()->getSampleTextAttribute() . "<br />";
        }
    }
}

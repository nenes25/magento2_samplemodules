<?php

namespace Hhennes\OrderAttributes\Controller\Test;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Sales\Api\OrderRepositoryInterface;

/**
 * Class Other
 * Même chose pour que la classe Index mais avec la version Magento 2.4 des controllers
 * @package Hhennes\OrderAttributes\Controller\Test
 */
class Other implements HttpGetActionInterface
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
     * @var ResultFactory
     */
    private $resultFactory;

    /**
     * Index constructor.
     * @param OrderRepositoryInterface $orderRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param ResultFactory $resultFactory
     */
    public function __construct(
        OrderRepositoryInterface $orderRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        ResultFactory $resultFactory
    ) {
        $this->orderRepository = $orderRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->resultFactory = $resultFactory;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $criteria = $this->searchCriteriaBuilder->create();
        $orders = $this->orderRepository->getList($criteria);

        $pageContent = '';
        /** @var  \Magento\Sales\Api\Data\OrderInterface $order */
        foreach ($orders as $order) {
            $pageContent.= "Sample Boolean Attribute for order " . $order->getIncrementId() . " : "
                . $order->getExtensionAttributes()->getSampleBooleanAttribute() . "<br />";
            $pageContent.= "Sample Int Attribute for order " . $order->getIncrementId() . " : "
                . $order->getExtensionAttributes()->getSampleIntAttribute() . "<br />";
            $pageContent.= "Sample Text Attribute for order " . $order->getIncrementId() . " : "
                . $order->getExtensionAttributes()->getSampleTextAttribute() . "<br />";
        }

        //Affichage la réponse
        $result= $this->resultFactory
            ->create(ResultFactory::TYPE_RAW)
            ->setHeader('Content-Type', 'text/html')
            ->setContents($pageContent);

        return $result;
    }
}

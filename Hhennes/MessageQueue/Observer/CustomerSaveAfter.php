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
 * @copyright since 2023 Hervé HENNES
 * @license   https://opensource.org/licenses/AFL-3.0  Academic Free License ("AFL") v. 3.0
 */

namespace Hhennes\MessageQueue\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\MessageQueue\PublisherInterface;
use Psr\Log\LoggerInterface;

class CustomerSaveAfter implements ObserverInterface
{

    /** @var string Message queue topic name */
    public const QUEUE_TOPIC_NAME = 'hhennes.messagequeue.customers';

    /** @var PublisherInterface */
    private PublisherInterface $publisher;
    /** @var LoggerInterface */
    private LoggerInterface $logger;

    /**
     * @param PublisherInterface $publisher
     * @param LoggerInterface $logger
     */
    public function __construct(
        PublisherInterface $publisher,
        LoggerInterface    $logger
    )
    {
        $this->publisher = $publisher;
        $this->logger = $logger;
    }

    /**
     * Add customer to message queue after save
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        try {
            $customer = $observer->getEvent()->getCustomer();
            $this->publisher->publish(self::QUEUE_TOPIC_NAME, $customer->getId());
        } catch (\Exception $e) {
            $this->logger->error(
                'Error when trying to publish customer ' . $e->getMessage(),
                ['exception' => $e->getTraceAsString()]
            );
        }
    }
}

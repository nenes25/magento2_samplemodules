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

namespace Hhennes\MessageQueue\Model\MessageQueues;

use Psr\Log\LoggerInterface;

class CustomerProcessor
{
    /** @var LoggerInterface  */
    private LoggerInterface $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(
        LoggerInterface $logger
    )
    {
        $this->logger = $logger;
    }

    /**
     * In the process function we get the identifier of the customer from the message queue
     *
     * I was not able to get an "int" from the message queue
     * The type of the argument must match with the declaration of request argument in communication.xml
     * <topic name="hhennes.messagequeue.customers" request="string"/>
     *
     * @param string $customerId
     * @return void
     */
    public function process(string $customerId): void
    {
        $this->logger->debug(
            sprintf('Get customer %d from message queue', (int)$customerId),
        );
    }

}

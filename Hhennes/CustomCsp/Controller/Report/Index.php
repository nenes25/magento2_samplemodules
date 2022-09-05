<?php
/**
 * Hervé HENNES
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * Available through the world-wide-web at this URL:
 * https://opensource.org/licenses/afl-3.0.php
 *
 * @author    Hervé HENNES <contact@h-hhennes.fr>
 * @copyright since 2022 Hervé HENNES
 * @license   https://opensource.org/licenses/AFL-3.0  Academic Free License ("AFL") v. 3.0
 */

namespace Hhennes\CustomCsp\Controller\Report;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\CsrfAwareActionInterface;
use Magento\Framework\App\Request\InvalidRequestException;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\NotFoundException;
use Psr\Log\LoggerInterface;

class Index implements HttpPostActionInterface, CsrfAwareActionInterface
{
    private LoggerInterface $logger;
    private ResultFactory $resultFactory;
    private RequestInterface $request;

    /**
     * @param ResultFactory $resultFactory
     * @param RequestInterface $request
     * @param LoggerInterface $logger
     */
    public function __construct(
        ResultFactory    $resultFactory,
        RequestInterface $request,
        LoggerInterface  $logger
    )
    {
        $this->logger = $logger;
        $this->resultFactory = $resultFactory;
        $this->request = $request;
    }


    /**
     * Execute action based on request and return result
     *
     * @return ResultInterface|ResponseInterface
     * @throws NotFoundException
     */
    public function execute()
    {
        $this->logger->debug(
            'Get csp report', ['details' => $this->request->getContent()]
        );

        return $this->resultFactory
            ->create(ResultFactory::TYPE_RAW)
            ->setHeader('Content-Type', 'text/html')
            ->setContents('Report logged');
    }

    /**
     * @inheritDoc
     */
    public function createCsrfValidationException(RequestInterface $request): ?InvalidRequestException
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function validateForCsrf(RequestInterface $request): ?bool
    {
        return true;
    }
}

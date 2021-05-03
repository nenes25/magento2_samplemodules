<?php
declare(strict_types=1);
namespace Hhennes\CustomRouter\Controller;

use Magento\Framework\App\Action\Forward;
use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\RouterInterface;
use Magento\Framework\App\ResponseInterface;

class Router implements RouterInterface
{
    /**
     * @var ActionFactory
     */
    private ActionFactory $actionFactory;
    /**
     * @var ResponseInterface
     */
    private ResponseInterface $response;

    /**
     * Router constructor.
     * @param ActionFactory $actionFactory
     * @param ResponseInterface $response
     */
    public function __construct(
        ActionFactory $actionFactory,
        ResponseInterface $response
    ) {
        $this->actionFactory = $actionFactory;
        $this->response = $response;
    }

    /**
     * @inheritDoc
     */
    public function match(RequestInterface $request): ?ActionInterface
    {
        //Get Request path info
        $pathInfo = trim($request->getPathInfo(), '/');
        //If the path info start with sample_router we take it
        if (strpos($pathInfo, 'sample_router') !== false) {
            $request->setModuleName('hhennes_customrouter');
            $request->setControllerName('custom');
            $request->setActionName('index');
            $request->setParams(['test' =>'ok']);

            /*dump($request);
            die('debug');*/

            //Redirect to the real controller
            return $this->actionFactory->create(
                Forward::class,
                ['request' => $request]
            );
        }

        return null;
    }
}

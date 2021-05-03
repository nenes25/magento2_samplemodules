<?php

namespace Hhennes\CustomRouter\Controller\Custom;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\RequestInterface;

class Index implements ActionInterface
{
    /**
     * @var PageFactory
     */
    private PageFactory $pageFactory;
    /**
     * @var RequestInterface
     */
    private RequestInterface $request;

    /**
     * Index constructor.
     * @param PageFactory $pageFactory
     * @param RequestInterface $request
     */
    public function __construct(
        PageFactory $pageFactory,
        RequestInterface $request
    ) {
        $this->pageFactory = $pageFactory;
        $this->request = $request;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        dump($this->request);
       return $this->pageFactory->create();
    }
}

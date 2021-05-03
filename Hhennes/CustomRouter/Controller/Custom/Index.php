<?php

namespace Hhennes\CustomRouter\Controller\Custom;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\View\Result\PageFactory;

class Index implements ActionInterface
{
    /**
     * @var PageFactory
     */
    private PageFactory $pageFactory;

    /**
     * Index constructor.
     * @param PageFactory $pageFactory
     */
    public function __construct(
        PageFactory $pageFactory
    ) {
        $this->pageFactory = $pageFactory;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
       return $this->pageFactory->create();
    }
}

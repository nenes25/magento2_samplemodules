<?php


namespace Hhennes\SalesAdminPdfViewer\Plugin\Controller\Adminhtml\Creditmemo\AbstractCreditmemo;

use Magento\Sales\Api\CreditmemoRepositoryInterface;
use Magento\Sales\Controller\Adminhtml\Creditmemo\AbstractCreditmemo\PrintAction;
use Magento\Sales\Model\Order\Pdf\CreditmemoFactory;
use Hhennes\SalesAdminPdfViewer\Model\PdfViewer;

class PrintActionPlugin
{

    /** @var string Type d'entité à imprimer */
    const PRINT_ENTITY_TYPE = 'creditmemo';

    /**
     * @var CreditmemoRepositoryInterface
     */
    private CreditmemoRepositoryInterface $creditmemoRepository;
    /**
     * @var \Magento\Backend\App\Action\Context
     */
    private \Magento\Backend\App\Action\Context $context;
    /**
     * @var CreditmemoFactory
     */
    private CreditmemoFactory $creditmemoFactory;
    /**
     * @var PdfViewer
     */
    private PdfViewer $pdfViewer;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param CreditmemoRepositoryInterface $creditmemoRepository
     * @param CreditmemoFactory $creditmemoFactory
     * @param PdfViewer $pdfViewer
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        CreditmemoRepositoryInterface $creditmemoRepository,
        CreditmemoFactory $creditmemoFactory,
        PdfViewer $pdfViewer
    ) {
        $this->creditmemoRepository = $creditmemoRepository;
        $this->context = $context;
        $this->creditmemoFactory = $creditmemoFactory;
        $this->pdfViewer = $pdfViewer;
    }

    /**
     * @param \Magento\Sales\Controller\Adminhtml\Creditmemo\AbstractCreditmemo\PrintAction $subject
     * @param callable $proceed
     * @return mixed
     * @throws \Zend_Pdf_Exception
     */
    public function beforeExecute(\Magento\Sales\Controller\Adminhtml\Creditmemo\AbstractCreditmemo\PrintAction $subject)
    {
        if ($this->pdfViewer->displayInBrowser()) {
            $creditmemoId = $this->context->getRequest()->getParam('creditmemo_id');
            if ($creditmemoId) {
                $creditmemo = $this->creditmemoRepository->get($creditmemoId);
                if ($creditmemo) {
                    $pdf = $this->creditmemoFactory->create()->getPdf(
                        [$creditmemo]
                    );
                    $this->pdfViewer->displayToBrowser(self::PRINT_ENTITY_TYPE, $pdf);
                    exit();
                }
            }
        }
    }
}

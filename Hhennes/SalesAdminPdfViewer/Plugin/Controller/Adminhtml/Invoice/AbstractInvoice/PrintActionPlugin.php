<?php

namespace Hhennes\SalesAdminPdfViewer\Plugin\Controller\Adminhtml\Invoice\AbstractInvoice;

use Magento\Backend\App\Action\Context;
use Magento\Sales\Api\InvoiceRepositoryInterface;
use Magento\Sales\Controller\Adminhtml\Invoice\AbstractInvoice\PrintAction;
use Magento\Sales\Model\Order\Pdf\InvoiceFactory;
use Hhennes\SalesAdminPdfViewer\Model\PdfViewer;

class PrintActionPlugin
{

    /** @var string Type of entity to print */
    const PRINT_ENTITY_TYPE = 'invoice';

    /** @var Context */
    private Context $context;
    /** @var InvoiceRepositoryInterface */
    private InvoiceRepositoryInterface $invoiceRepository;
    /** @var InvoiceFactory */
    private InvoiceFactory $invoiceFactory;
    private PdfViewer $pdfViewer;

    /**
     * PrintActionPlugin constructor.
     * @param Context $context
     * @param InvoiceRepositoryInterface $invoiceRepository
     * @param InvoiceFactory $invoice
     */
    public function __construct(
        Context $context,
        InvoiceRepositoryInterface $invoiceRepository,
        InvoiceFactory $invoiceFactory,
        PdfViewer $pdfViewer
    )
    {
        $this->context = $context;
        $this->invoiceRepository = $invoiceRepository;
        $this->invoiceFactory = $invoiceFactory;
        $this->pdfViewer = $pdfViewer;
    }

    /**
     * @param PrintAction $subject
     * @throws \Zend_Pdf_Exception
     */
    public function beforeExecute(\Magento\Sales\Controller\Adminhtml\Invoice\AbstractInvoice\PrintAction $subject)
    {
        if ($this->pdfViewer->displayInBrowser()) {
            $invoiceId = $this->context->getRequest()->getParam('invoice_id');
            if ($invoiceId) {
                $invoice = $this->invoiceRepository->get($invoiceId);
                if ($invoice) {
                    $pdf = $this->invoiceFactory->create()->getPdf(
                        [$invoice]
                    );
                    $this->pdfViewer->displayToBrowser(self::PRINT_ENTITY_TYPE, $pdf);
                    exit();
                }
            }
        }
    }
}

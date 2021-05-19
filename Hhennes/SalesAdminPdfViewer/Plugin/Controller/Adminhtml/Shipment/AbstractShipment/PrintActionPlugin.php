<?php


namespace Hhennes\SalesAdminPdfViewer\Plugin\Controller\Adminhtml\Shipment\AbstractShipment;


use Magento\Sales\Controller\Adminhtml\Shipment\AbstractShipment\PrintAction;
use Magento\Sales\Api\ShipmentRepositoryInterface;
use Magento\Sales\Model\Order\Pdf\ShipmentFactory;
use Hhennes\SalesAdminPdfViewer\Model\PdfViewer;

class PrintActionPlugin
{

    /** @var string Type d'entité à imprimer */
    const PRINT_ENTITY_TYPE = 'shipment';
    private ShipmentRepositoryInterface $shipmentRepository;
    private ShipmentFactory $shipmentFactory;
    private PdfViewer $pdfViewer;
    private \Magento\Backend\App\Action\Context $context;

    /**
     * PrintActionPlugin constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param ShipmentRepositoryInterface $shipmentRepository
     * @param ShipmentFactory $shipmentFactory
     * @param PdfViewer $pdfViewer
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        ShipmentRepositoryInterface $shipmentRepository,
        ShipmentFactory $shipmentFactory,
        PdfViewer $pdfViewer
    )
    {
        $this->shipmentRepository = $shipmentRepository;
        $this->shipmentFactory = $shipmentFactory;
        $this->pdfViewer = $pdfViewer;
        $this->context = $context;
    }

    /**
     * @param \Magento\Sales\Controller\Adminhtml\Shipment\AbstractShipment\PrintAction $subject
     */
    public function beforeExecute(\Magento\Sales\Controller\Adminhtml\Shipment\AbstractShipment\PrintAction $subject)
    {
        if ($this->pdfViewer->displayInBrowser()) {
            $shipmentId = $this->context->getRequest()->getParam('shipment_id');
            if ($shipmentId) {
                $shipment = $this->shipmentRepository->get($shipmentId);
                if ($shipment) {
                    $pdf = $this->shipmentFactory->create()->getPdf(
                        [$shipment]
                    );
                    $this->pdfViewer->displayToBrowser(self::PRINT_ENTITY_TYPE, $pdf);
                    exit();
                }
            }
        }
    }
}

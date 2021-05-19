<?php


namespace Hhennes\SalesAdminPdfViewer\Model;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\App\Config\ScopeConfigInterface;

class PdfViewer
{

    /** @var string Configuration path to enable pdf display */
    const XML_PATH_ENABLE_VIEWER = 'hhennes_salesadminpdfviewer/settings/enable_pdf_display';

    /** @var ScopeConfigInterface  */
    private ScopeConfigInterface $scopeConfig;

    /**
     * PdfViewer constructor.
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return bool
     */
    public function displayInBrowser():bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_ENABLE_VIEWER);
    }

    /**
     * Force pdf render in browser
     * @param string $type
     * @param \Zend_Pdf $pdf
     * @throws \Zend_Pdf_Exception
     */
    public function displayToBrowser(string $type, \Zend_Pdf $pdf):void
    {
        header('Content-type:application/pdf');
        header('Content-disposition: inline; filename="view.pdf"');
        $content = $pdf->render(false);
        echo $content;
    }
}

<?php


namespace Hhennes\CustomerExtensionAttributes\Controller\Test;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;

class Index implements HttpGetActionInterface
{
    /**
     * @var ResultFactory
     */
    private ResultFactory $resultFactory;
    /**
     * @var CustomerRepositoryInterface
     */
    private CustomerRepositoryInterface $customerRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    private SearchCriteriaBuilder $searchCriteriaBuilder;
    /**
     * @var RequestInterface
     */
    private RequestInterface $request;

    /**
     * Index constructor.
     * @param RequestInterface $request
     * @param CustomerRepositoryInterface $customerRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param ResultFactory $resultFactory
     */
    public function __construct(
        RequestInterface $request,
        CustomerRepositoryInterface $customerRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        ResultFactory $resultFactory
    ) {
        $this->resultFactory = $resultFactory;
        $this->customerRepository = $customerRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->request = $request;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        if ($id_customer =  $this->request->getParam('id_customer')) {
            $customer = $this->customerRepository->getById($id_customer);
            dump($customer);
            $pageContent = '';
        } else {
            $pageContent = 'Please add a param customer_id in url to load customer data';
        }

        return $this->resultFactory
            ->create(ResultFactory::TYPE_RAW)
            ->setHeader('Content-Type', 'text/html')
            ->setContents($pageContent);
    }

    protected function _getCustomer()
    {
    }
}

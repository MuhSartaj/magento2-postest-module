<?php
declare(strict_types=1);

namespace Sartaj\PosTest\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{

    protected $resultPageFactory;

    protected $pageLimit = 1;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Action\Context  $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\HTTP\Client\Curl $curl,
        \Sartaj\PosTest\Helper\Data $apiHelper
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_api_helper = $apiHelper;
        $this->_curl = $curl;
        parent::__construct($context);
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /*echo 'size: '.$this->getJsonDataSize();
        return ;*/
        /*echo '<pre>';
        print_r($this->getJsonDataSize());
        echo '</pre>';*/
        for($i = 1; $i <= $this->getJsonDataSize(); $i++) {
            $this->pageLimit = $i;
            /*$response = json_decode($this->getJsonData(), true);*/
            echo 'Size: '.$this->pageLimit.'<br>';
        }
        exit('hi');
        /*return $this->resultPageFactory->create();*/
    }

    private function getJsonData(){
        /*$this->_curl->addHeader("Content-Type", "application/json");
        $this->_curl->addHeader("Content-Length", 200);*/
        $this->_curl->get($this->_getApiUrl());
        return $this->_curl->getBody();
    }

    private function _getApiUrl(){
        return "https://trialapi.craig.mtcdevserver.com/api/properties?api_key=3NLTTNlXsi6rBWl7nYGluOdkl2htFHug&page[size]=100&page[number]=".$this->pageLimit;
    }


    private function getJsonDataSize(){
        $response = json_decode($this->getJsonData(), true);
        return $response['last_page'];
    }
}

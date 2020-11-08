<?php
/**
 * Copyright © 2015 Sartaj . All rights reserved.
 */
namespace Sartaj\PosTest\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
	
	protected $_curl;
	
	protected $limit = 100;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\HTTP\Client\Curl $curl
     */

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\HTTP\Client\Curl $curl
    ) {
        parent::__construct($context);
        $this->_curl = $curl;
    }

    public function _getApiData(){
    	$this->_curl->addHeader("Content-Type", "application/json");
		$this->_curl->addHeader("Content-Length", 200);
    	$this->_curl->get($this->_getApiUrl());
    	return $this->curl->getBody();
    }

    private function _getApiUrl(){
    	return "https://trialapi.craig.mtcdevserver.com/api/properties?api_key=3NLTTNlXsi6rBWl7nYGluOdkl2htFHug&page[size]=100";
    }
}
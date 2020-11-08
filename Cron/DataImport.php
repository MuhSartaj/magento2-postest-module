<?php

namespace Sartaj\PosTest\Cron;


class DataImport {
 
 	protected $logger;

 	protected $_pageSize = 1;

 	protected $_index = 1;

 	protected $_url;

	public function __construct(
		\Magento\Framework\App\Helper\Context $context,
		\Psr\Log\LoggerInterface $logger,
		\Magento\Framework\App\ResourceConnection $resource,
		\Sartaj\PosTest\Model\ResourceModel\Grid\Collection $posModelFactory,
		\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
		\Magento\Framework\HTTP\Client\Curl $curl
	)
	{
	    $this->logger = $logger;
	    $this->_curl = $curl;
	    $this->connection = $resource->getConnection();
    	$this->resource = $resource;
    	$this->_posModelFactory = $posModelFactory;
    	$this->_scopeConfig = $scopeConfig;
    	$this->_apiKey = $this->_scopeConfig->getValue('pos_configuration/general/api_key',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    	$this->_apiUrl = $this->_scopeConfig->getValue('pos_configuration/general/api_url',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
	}
    public function execute() {
    	$this->importRecords();
    	return $this;
    }

    private function importRecords(){
    	try{
			$size = $this->getJsonDataSize();
			if($size == 'error'){
				$this->logger->debug("Error Processing Request\n");
				return;
			}
			$this->_index = $this->_getStartIndex();
			$counter = 0;
			for($i = $this->_index; $i <= $size; $i++){
				if($counter == 50) break;
				$collection = [];
				$jsonData = $this->getJsonData();
				$productCol = json_decode($jsonData, true);
				foreach ($productCol['data'] as $index => $record) {
					$collection[] = [
				        'uuid' => @$record['uuid'],
				        'county' => @$record['county'],
				        'country' => @$record['country'],
				        'town' => @$record['town'],
				        'descriptions' => @$record['description'],
				        'displayable_address' => @$record['address'],
				        'image_url' => @$record['image_full'],
				        'thumbnail_url' => @$record['image_thumbnail'],
				        'latitude' => @$record['latitude'],
				        'longitude' => @$record['longitude'],
				        'number_of_bedrooms' => @$record['num_bedrooms'],
				        'number_of_bathrooms' => @$record['num_bathrooms'],
				        'price' => @$record['price'],
				        'property_type' => @$record['property_type']['title'],
				        'sale_rent' => @$record['type'],
				        'created_at' => date('Y-m-d H:s:i')
				    ];   
				}
				$this->insertMultiple('postest_grid', $collection);
				$this->logger->debug($i.' of '.$size);
				$this->logger->debug($i.': Status: '.$this->_curl->getStatus());
				$this->logger->debug($i.'json: '.json_encode($collection));
				$counter++;
			}
		}
		catch(\Exception $e){
			$this->logger->debug('Error: '.$e->getMessage());
	    }
    }

    private function getJsonData(){
        $this->_curl->get($this->_getApiUrl());
        return $this->_curl->getBody();
    }

    private function _getApiUrl(){
        /*return "https://trialapi.craig.mtcdevserver.com/api/properties?api_key=3NLTTNlXsi6rBWl7nYGluOdkl2htFHug&page[size]=100&page[number]=".$this->_pageSize;*/
        return trim($this->_apiUrl).'?api_key='.trim($this->_apiKey).'&page[size]=100&page[number]='.trim($this->_pageSize);
    }


    private function getJsonDataSize(){
        $response = json_decode($this->getJsonData());
        return isset($response->last_page) ? $response->last_page : $response->status;
    }

    private function insertMultiple($table, $data)
	{
	    try {
	        $tbl = $this->resource->getTableName($table);
	        return $this->connection->insertOnDuplicate($tbl, $data);
	    } catch (\Exception $e) {
	       $this->logger->debug('Insertation Error: '.$e->getMessage());
	    }
	}

	private function _getStartIndex(){
		$collection = $this->_posModelFactory->load();
		return (count($collection->getData()) / 100) + 1;
	}
}
<?php
namespace Sartaj\PosTest\Block\Adminhtml\Grid;


class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var \Magento\Framework\Module\Manager
     */
    protected $moduleManager;

    /**
     * @var \Magento\Eav\Model\ResourceModel\Entity\Attribute\Set\CollectionFactory]
     */
    protected $_setsFactory;

    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    protected $_productFactory;

    /**
     * @var \Magento\Catalog\Model\Product\Type
     */
    protected $_type;

    /**
     * @var \Magento\Catalog\Model\Product\Attribute\Source\Status
     */
    protected $_status;
	protected $_collectionFactory;

    /**
     * @var \Magento\Catalog\Model\Product\Visibility
     */
    protected $_visibility;

    /**
     * @var \Magento\Store\Model\WebsiteFactory
     */
    protected $_websiteFactory;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Magento\Store\Model\WebsiteFactory $websiteFactory
     * @param \Magento\Eav\Model\ResourceModel\Entity\Attribute\Set\CollectionFactory $setsFactory
     * @param \Magento\Catalog\Model\ProductFactory $productFactory
     * @param \Magento\Catalog\Model\Product\Type $type
     * @param \Magento\Catalog\Model\Product\Attribute\Source\Status $status
     * @param \Magento\Catalog\Model\Product\Visibility $visibility
     * @param \Magento\Framework\Module\Manager $moduleManager
     * @param array $data
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Magento\Store\Model\WebsiteFactory $websiteFactory,
		\Sartaj\PosTest\Model\ResourceModel\Grid\Collection $collectionFactory,
        \Magento\Framework\Module\Manager $moduleManager,
        array $data = []
    ) {
		
		$this->_collectionFactory = $collectionFactory;
        $this->_websiteFactory = $websiteFactory;
        $this->moduleManager = $moduleManager;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
		
        $this->setId('productGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(false);
       
    }

    /**
     * @return Store
     */
    protected function _getStore()
    {
        $storeId = (int)$this->getRequest()->getParam('store', 0);
        return $this->_storeManager->getStore($storeId);
    }

    /**
     * @return $this
     */
    protected function _prepareCollection()
    {
		try{
			
			
			$collection =$this->_collectionFactory->load();

		  

			$this->setCollection($collection);

			parent::_prepareCollection();
		  
			return $this;
		}
		catch(Exception $e)
		{
			echo $e->getMessage();die;
		}
    }

    /**
     * @param \Magento\Backend\Block\Widget\Grid\Column $column
     * @return $this
     */
    protected function _addColumnFilterToCollection($column)
    {
        if ($this->getCollection()) {
            if ($column->getId() == 'websites') {
                $this->getCollection()->joinField(
                    'websites',
                    'catalog_product_website',
                    'website_id',
                    'product_id=entity_id',
                    null,
                    'left'
                );
            }
        }
        return parent::_addColumnFilterToCollection($column);
    }

    /**
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'id',
            [
                'header' => __('ID'),
                'type' => 'number',
                'index' => 'id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );
		$this->addColumn(
            'uuid',
            [
                'header' => __('UUID'),
                'index' => 'uuid',
                'class' => 'uuid'
            ]
        );
		$this->addColumn(
            'county',
            [
                'header' => __('County'),
                'index' => 'county',
                'class' => 'county'
            ]
        );
		$this->addColumn(
            'country',
            [
                'header' => __('Country'),
                'index' => 'country',
                'class' => 'country'
            ]
        );
		$this->addColumn(
            'town',
            [
                'header' => __('Town'),
                'index' => 'town',
                'class' => 'town'
            ]
        );
		$this->addColumn(
            'descriptions',
            [
                'header' => __('Descriptions'),
                'index' => 'descriptions',
                'class' => 'descriptions'
            ]
        );
		$this->addColumn(
            'displayable_address',
            [
                'header' => __('Displayable address'),
                'index' => 'displayable_address',
                'class' => 'displayable_address'
            ]
        );
		$this->addColumn(
            'image_url',
            [
                'header' => __('Image Url'),
                'index' => 'image_url',
                'class' => 'image_url'
            ]
        );
		$this->addColumn(
            'thumbnail_url',
            [
                'header' => __('Thumbnail Url'),
                'index' => 'thumbnail_url',
                'class' => 'thumbnail_url'
            ]
        );
		$this->addColumn(
            'latitude',
            [
                'header' => __('Latitude'),
                'index' => 'latitude',
                'class' => 'latitude'
            ]
        );
		$this->addColumn(
            'longitude',
            [
                'header' => __('Longitude'),
                'index' => 'longitude',
                'class' => 'longitude'
            ]
        );
		$this->addColumn(
            'number_of_bedrooms',
            [
                'header' => __('Number of bedrooms'),
                'index' => 'number_of_bedrooms',
                'class' => 'number_of_bedrooms'
            ]
        );
		$this->addColumn(
            'number_of_bathrooms',
            [
                'header' => __('Number of bathrooms'),
                'index' => 'number_of_bathrooms',
                'class' => 'number_of_bathrooms'
            ]
        );
		$this->addColumn(
            'price',
            [
                'header' => __('Price'),
                'index' => 'price',
                'class' => 'price'
            ]
        );
		$this->addColumn(
            'property_type',
            [
                'header' => __('Property type'),
                'index' => 'property_type',
                'class' => 'property_type'
            ]
        );
		$this->addColumn(
            'sale_rent',
            [
                'header' => __('Sale / Rent'),
                'index' => 'sale_rent',
                'class' => 'sale_rent'
            ]
        );
		$this->addColumn(
            'created_at',
            [
                'header' => __('Created at'),
                'index' => 'created_at',
                'type' => 'date',
            ]
        );
		/*{{CedAddGridColumn}}*/

        $block = $this->getLayout()->getBlock('grid.bottom.links');
        if ($block) {
            $this->setChild('grid.bottom.links', $block);
        }

        return parent::_prepareColumns();
    }

     /**
     * @return $this
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('id');

        $this->getMassactionBlock()->addItem(
            'delete',
            array(
                'label' => __('Delete'),
                'url' => $this->getUrl('postest/*/massDelete'),
                'confirm' => __('Are you sure?')
            )
        );
        return $this;
    }

    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('postest/*/index', ['_current' => true]);
    }

    /**
     * @param \Magento\Catalog\Model\Product|\Magento\Framework\Object $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl(
            'postest/*/edit',
            ['store' => $this->getRequest()->getParam('store'), 'id' => $row->getId()]
        );
    }
}

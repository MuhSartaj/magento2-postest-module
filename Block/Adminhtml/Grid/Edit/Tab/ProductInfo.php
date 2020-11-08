<?php
namespace Sartaj\PosTest\Block\Adminhtml\Grid\Edit\Tab;
class ProductInfo extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        array $data = array()
    ) {
        $this->_systemStore = $systemStore;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
		/* @var $model \Magento\Cms\Model\Page */
        $model = $this->_coreRegistry->registry('postest_grid');
		$isElementDisabled = false;
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('page_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend' => __('Product info')));

        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', array('name' => 'id'));
        }

		$fieldset->addField(
            'uuid',
            'text',
            array(
                'name' => 'uuid',
                'label' => __('UUID'),
                'title' => __('UUID'),
            )
        );
		$fieldset->addField(
            'county',
            'text',
            array(
                'name' => 'county',
                'label' => __('County'),
                'title' => __('County'),
                /*'required' => true,*/
            )
        );
		$fieldset->addField(
            'country',
            'text',
            array(
                'name' => 'country',
                'label' => __('Country'),
                'title' => __('Country'),
                /*'required' => true,*/
            )
        );
		$fieldset->addField(
            'town',
            'text',
            array(
                'name' => 'town',
                'label' => __('Town'),
                'title' => __('Town'),
                /*'required' => true,*/
            )
        );
		$fieldset->addField(
            'descriptions',
            'textarea',
            array(
                'name' => 'descriptions',
                'label' => __('Descriptions'),
                'title' => __('Descriptions'),
                /*'required' => true,*/
            )
        );
		$fieldset->addField(
            'displayable_address',
            'text',
            array(
                'name' => 'displayable_address',
                'label' => __('Displayable address'),
                'title' => __('Displayable address'),
                /*'required' => true,*/
            )
        );
		$fieldset->addField(
            'image_url',
            'text',
            array(
                'name' => 'image_url',
                'label' => __('Image url'),
                'title' => __('Image url'),
                /*'required' => true,*/
            )
        );
		$fieldset->addField(
            'thumbnail_url',
            'text',
            array(
                'name' => 'thumbnail_url',
                'label' => __('Thumbnail url'),
                'title' => __('Thumbnail url'),
                /*'required' => true,*/
            )
        );
		$fieldset->addField(
            'latitude',
            'text',
            array(
                'name' => 'latitude',
                'label' => __('Latitude'),
                'title' => __('Latitude'),
                /*'required' => true,*/
            )
        );
		$fieldset->addField(
            'longitude',
            'text',
            array(
                'name' => 'longitude',
                'label' => __('Longitude'),
                'title' => __('Longitude'),
                /*'required' => true,*/
            )
        );
		$fieldset->addField(
            'number_of_bedrooms',
            'text',
            array(
                'name' => 'number_of_bedrooms',
                'label' => __('Number of bedrooms'),
                'title' => __('Number of bedrooms'),
                /*'required' => true,*/
            )
        );
		$fieldset->addField(
            'number_of_bathrooms',
            'text',
            array(
                'name' => 'number_of_bathrooms',
                'label' => __('Number of bathrooms'),
                'title' => __('Number of bathrooms'),
                /*'required' => true,*/
            )
        );
		$fieldset->addField(
            'price',
            'text',
            array(
                'name' => 'price',
                'label' => __('Price'),
                'title' => __('Price'),
                /*'required' => true,*/
            )
        );
		$fieldset->addField(
            'property_type',
            'text',
            array(
                'name' => 'property_type',
                'label' => __('Property type'),
                'title' => __('Property type'),
                /*'required' => true,*/
            )
        );
		$fieldset->addField(
            'sale_rent',
            'select',
            array(
                'name' => 'sale_rent',
                'label' => __('For sale / rent'),
                'title' => __('For sale / rent'),
                'options' => [
                                'sale' => __('Sale'), 
                                'rent' => __('Rent')
                            ]
                /*'required' => true,*/
            )
        );
		/*$fieldset->addField(
            'created_at',
            'date',
            array(
                'name' => 'created_at',
                'label' => __('created at'),
                'title' => __('created at'),
				'format' => 'yy-mm-dd',
            )
        );*/
		
		/*{{CedAddFormField}}*/
        
        if (!$model->getId()) {
            $model->setData('status', $isElementDisabled ? '2' : '1');
        }

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();   
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('Product info');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('Product info');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}

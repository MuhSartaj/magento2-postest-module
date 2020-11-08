<?php
namespace Sartaj\PosTest\Block\Adminhtml;
class Grid extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
		
        $this->_controller = 'adminhtml_grid';/*block grid.php directory*/
        $this->_blockGroup = 'Sartaj_PosTest';
        $this->_headerText = __('Grid');
        $this->_addButtonLabel = __('Add New'); 
        parent::_construct();
		
    }
}

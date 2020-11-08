<?php
namespace Sartaj\PosTest\Block\Adminhtml\Grid\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    protected function _construct()
    {
		
        parent::_construct();
        $this->setId('checkmodule_grid_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Grid Information'));
    }
}
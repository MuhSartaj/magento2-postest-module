<?php
/**
 * Copyright © 2015 Sartaj. All rights reserved.
 */
namespace Sartaj\PosTest\Model\ResourceModel;

/**
 * Grid resource
 */
class Grid extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('postest_grid', 'id');
    }

  
}

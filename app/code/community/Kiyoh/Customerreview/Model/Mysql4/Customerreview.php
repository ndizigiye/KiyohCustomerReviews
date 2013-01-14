<?php

class Kiyoh_Customerreview_Model_Mysql4_Customerreview extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the customerreview_id refers to the key field in your database table.
        $this->_init('customerreview/customerreview', 'customerreview_id');
    }
}
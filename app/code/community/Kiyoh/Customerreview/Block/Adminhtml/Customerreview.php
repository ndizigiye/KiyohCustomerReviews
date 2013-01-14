<?php
class Kiyoh_Customerreview_Block_Adminhtml_Customerreview extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_customerreview';
    $this->_blockGroup = 'customerreview';
    $this->_headerText = Mage::helper('customerreview')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('customerreview')->__('Add Item');
    parent::__construct();
  }
}
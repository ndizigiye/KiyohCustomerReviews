<?php
class Kiyoh_Customerreview_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/customerreview?id=15 
    	 *  or
    	 * http://site.com/customerreview/id/15 	
    	 */
    	/* 
		$customerreview_id = $this->getRequest()->getParam('id');

  		if($customerreview_id != null && $customerreview_id != '')	{
			$customerreview = Mage::getModel('customerreview/customerreview')->load($customerreview_id)->getData();
		} else {
			$customerreview = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($customerreview == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$customerreviewTable = $resource->getTableName('customerreview');
			
			$select = $read->select()
			   ->from($customerreviewTable,array('customerreview_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$customerreview = $read->fetchRow($select);
		}
		Mage::register('customerreview', $customerreview);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}
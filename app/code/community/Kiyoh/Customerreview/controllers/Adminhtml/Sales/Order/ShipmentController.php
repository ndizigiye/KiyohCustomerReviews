<?php

require_once 'Mage/Adminhtml/controllers/Sales/Order/ShipmentController.php'; 

/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright   Copyright (c) 2010 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Adminhtml sales order shipment controller
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Kiyoh_Customerreview_Adminhtml_Sales_Order_ShipmentController extends Mage_Adminhtml_Sales_Order_ShipmentController
{

    /**
     * Initialize shipment items QTY
     */

    /**
     * Save shipment
     * We can save only new shipment. Existing shipments are not editable
     */
    public function saveAction()
    {
	$kiyoh_tablePrefix = 	Mage::getConfig()->getTablePrefix();
		$kiyoh_read = Mage::getSingleton('core/resource')->getConnection('core_read');
	/**
	*Find shipment configuration
	*According to store Id
	*/
	    $data = $this->getRequest()->getPost('shipment');
        if (!empty($data['comment_text'])) {
            Mage::getSingleton('adminhtml/session')->setCommentText($data['comment_text']);
        }

        try {
            if ($shipment = $this->_initShipment()) {
                $shipment->register();

                $comment = '';
                if (!empty($data['comment_text'])) {
                    $shipment->addComment($data['comment_text'], isset($data['comment_customer_notify']), isset($data['is_visible_on_front']));
                    if (isset($data['comment_customer_notify'])) {
                        $comment = $data['comment_text'];
                    }
                }

                if (!empty($data['send_email'])) {
                    $shipment->setEmailSent(true);
                }

                $shipment->getOrder()->setCustomerNoteNotify(!empty($data['send_email']));
                $this->_saveShipment($shipment);
                $shipment->sendEmail(!empty($data['send_email']), $comment);
				
				/*********************autoreview work****************/
				$cuId = $shipment->getData();
				/**
				*Create multisite and multistore concept
				*/
				/**
				*define section of kiyoh configuration variable
				*start coding
				*/

				$kiyoh_status = '';
				$kiyoh_eventval='';
				$kiyoh_connector = '';
				$kiyoh_action = '';
				$kiyoh_user = '';
				$kiyoh_delay ='';
				$kiyoh_eventval = '';
				
				/**
				*Create multisite and multistore concept
				*/
				
				$kiyoh_storeId = $cuId['store_id'];
				
				/**
				*core connection in magento
				*/

	$kiyoh_val_detail = $kiyoh_read->fetchAll("SELECT * FROM ".$kiyoh_tablePrefix."core_store where store_id = '".$kiyoh_storeId."'");

	
			$kiyoh_websiteId = $kiyoh_val_detail[0]['website_id'];
		$kiyoh_core_detail = $kiyoh_read->fetchAll("SELECT * FROM ".$kiyoh_tablePrefix."core_config_data where 	scope_id = '".$kiyoh_storeId."'");
		
	
		
				foreach($kiyoh_core_detail as $value)
				{
				
					if($value['path'] ==  	'customconfig/review_group/custom_enable')
					{
					$kiyoh_status = $value['value']; 
					}
					if($value['path'] ==  	'customconfig/review_group/custom_connector')
					{
					$kiyoh_connector = $value['value']; 
					}
					if($value['path'] ==  	'customconfig/review_group/custom_action')
					{
					$kiyoh_action = $value['value']; 
					}
					if($value['path'] ==  	'customconfig/review_group/custom_user')
					{
					$kiyoh_user = $value['value']; 
					}
					if($value['path'] ==  	'customconfig/review_group/custom_delay')
					{
					$kiyoh_delay = $value['value']; 
					}
					if($value['path'] ==  	'customconfig/review_group/custom_event')
					{
					$kiyoh_eventval = $value['value']; 
					}
				
				}
				
				if($kiyoh_status == '')
				{
				$kiyoh_status = Mage::getStoreConfig('customconfig/review_group/custom_enable');
				}
				if($kiyoh_eventval == '')
				{
				$kiyoh_eventval = Mage::getStoreConfig('customconfig/review_group/custom_event');
				}
				if($kiyoh_connector == '')
				{
				$kiyoh_connector = Mage::getStoreConfig('customconfig/review_group/custom_connector');
				}
				if($kiyoh_action == '')
				{
				$kiyoh_action = Mage::getStoreConfig('customconfig/review_group/custom_action');
				}
				if($kiyoh_user == '')
				{
				$kiyoh_user = Mage::getStoreConfig('customconfig/review_group/custom_user');
				}
				if($kiyoh_delay == '')
				{
				$kiyoh_delay = Mage::getStoreConfig('customconfig/review_group/custom_delay');
				}
				
		

				
				
				$idss =  $cuId['customer_id'];

				$model = Mage::getModel('customer/customer')->load($idss);
				$collection = $model->getCollection();
					foreach($collection as $item)
							{
								$data11 = $item->getData();
							}


 
if($cuId['customer_id'] == '')
{
$orderidss =  $cuId['order_id'];			


$order = Mage::getModel('sales/order');

$dateO = $order->load($orderidss); 
$detailMail = $dateO->getdata();

$kiyoh_email = $detailMail['customer_email'];
}
else
{
				$kiyoh_email = $data11['email'];
}
					


if($kiyoh_eventval == 'Shipping' &&  $kiyoh_status =='1')
{

////call url
         // create a new cURL resource
//Create a curl handle
$url = 'https://www.kiyoh.nl/set.php?user='.$kiyoh_user.'&connector='.$kiyoh_connector.'&action='.$kiyoh_action.'&targetMail='.$kiyoh_email.'&delay='.$kiyoh_delay;
 		// create a new cURL resource
		$curl = curl_init();

		// set URL and other appropriate options
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HEADER, false);

 		
		// grab URL and pass it to the browser

		curl_exec($curl);

		if (curl_errno($curl)) {
    		print curl_error($curl);exit;
		} else {
		
    		curl_close($curl);
		}



// Close handle
curl_close($ch);



////call url


}

				/*********************autoreview work****************/
				
                $this->_getSession()->addSuccess($this->__('The shipment has been created.'));
                Mage::getSingleton('adminhtml/session')->getCommentText(true);
                $this->_redirect('*/sales_order/view', array('order_id' => $shipment->getOrderId()));
                return;
            } else {
                $this->_forward('noRoute');
                return;
            }
        } catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        } catch (Exception $e) {
            $this->_getSession()->addError($this->__('Cannot save shipment.'));
        }
        $this->_redirect('*/*/new', array('order_id' => $this->getRequest()->getParam('order_id')));
    }

    /**
     * Send email with shipment data to customer
     */
   
}

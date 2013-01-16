<?php
/**
 * My own options
 *
 */
class Kiyoh_Customerreview_Adminhtml_Model_System_Config_Source_Reviewevents
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 'Shipping', 'label'=>Mage::helper('adminhtml')->__('Shipping')),
            array('value' => 'Purchase', 'label'=>Mage::helper('adminhtml')->__('Purchase')),
           
        );
    }

}
?>
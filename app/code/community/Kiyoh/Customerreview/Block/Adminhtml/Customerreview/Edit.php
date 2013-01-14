<?php

class Kiyoh_Customerreview_Block_Adminhtml_Customerreview_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'customerreview';
        $this->_controller = 'adminhtml_customerreview';
        
        $this->_updateButton('save', 'label', Mage::helper('customerreview')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('customerreview')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('customerreview_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'customerreview_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'customerreview_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('customerreview_data') && Mage::registry('customerreview_data')->getId() ) {
            return Mage::helper('customerreview')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('customerreview_data')->getTitle()));
        } else {
            return Mage::helper('customerreview')->__('Add Item');
        }
    }
}
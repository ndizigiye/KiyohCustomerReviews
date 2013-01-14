<?php

class Kiyoh_Customerreview_Block_Adminhtml_Customerreview_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('customerreview_form', array('legend'=>Mage::helper('customerreview')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('customerreview')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('customerreview')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('customerreview')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('customerreview')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('customerreview')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('customerreview')->__('Content'),
          'title'     => Mage::helper('customerreview')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getCustomerreviewData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getCustomerreviewData());
          Mage::getSingleton('adminhtml/session')->setCustomerreviewData(null);
      } elseif ( Mage::registry('customerreview_data') ) {
          $form->setValues(Mage::registry('customerreview_data')->getData());
      }
      return parent::_prepareForm();
  }
}
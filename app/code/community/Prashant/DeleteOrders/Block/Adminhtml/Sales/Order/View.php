<?php
class Prashant_DeleteOrders_Block_Adminhtml_Sales_Order_View extends Mage_Adminhtml_Block_Sales_Order_View{
    
    public function __construct(){
         parent::__construct();
         $message = Mage::helper('adminhtml')->__('Are you sure you wnat to delete this order?');
         $this->_addButton('button_id', array(
            'label'     => Mage::helper('Sales')->__('Delete Order'),
            'onclick'   => 'deleteConfirm(\''.$message.'\', \'' . $this->getUrl('*/sales_order/delete') . '\')',
            'class'     => 'go'
        ), 0, 100, 'header', 'header');
    }
}

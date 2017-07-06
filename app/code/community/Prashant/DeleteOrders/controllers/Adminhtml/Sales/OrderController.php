<?php
require_once 'Mage/Adminhtml/controllers/Sales/OrderController.php';
class Prashant_DeleteOrders_Adminhtml_Sales_OrderController extends Mage_Adminhtml_Sales_OrderController{
    
	/* Function for Delete*/
    public function deleteAction(){
        $order_id = $this->getRequest()->getParam('order_id');
      
        if($order_id){
        $order = Mage::getModel('sales/order')->load($order_id);
        try{
        $order->delete()->unsetAll();
        if($this->removeAllData($order_id)){
        $message = Mage::helper('adminhtml')->__('Order was successfully deleted.');
        Mage::getSingleton('adminhtml/session')->addSuccess($message);
	$this->_redirectUrl(Mage::helper('adminhtml')->getUrl('adminhtml/sales_order/index'));
        }
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
           $this->_redirectUrl(Mage::helper('adminhtml')->getUrl('adminhtml/sales_order/index'));
          }
        }
        
    }
    
    public function deleteMassAction(){
        $order_ids = $this->getRequest()->getParam('order_ids');
        if(!is_array($order_ids)){
            $message = Mage::helper('adminhtml')->__('Please select item(s).');
            Mage::getSingleton('adminhtml/session')->addError($message);
        }
        else{
            try{
            foreach($order_ids as $order_id){
                $order = Mage::getModel('sales/order')->load($order_id);
                $order->delete()->unsetAll();
                $this->removeAllData($order_id);
            }
             $message = Mage::helper('adminhtml')->__('Total of %d record(s) were successfully deleted.', count($order_ids));
                Mage::getSingleton('adminhtml/session')->addSuccess($message);
         
            }catch(Exception $e){
            
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            
        }
        $this->_redirectUrl(Mage::helper('adminhtml')->getUrl('adminhtml/sales_order/index'));

    }
    
	/* Function Remove All Data*/
    public function removeAllData($order_id){
        $dbResource = Mage::getSingleton('core/resource');
        $db_obj = $dbResource->getConnection('core_read');
        $orderTable = $dbResource->getTableName('sales_flat_order_grid');
        $invoiceTable = $dbResource->getTableName('sales_flat_invoice_grid');
        $shipmentTable = $dbResource->getTableName('sales_flat_shipment_grid');
        $creditmemotab = $dbResource->getTableName('sales_flat_creditmemo_grid');
        $sql = "DELETE FROM  " . $orderTable . " WHERE entity_id = " . $order_id . ";";
        $db_obj->query($sql);
        $sql = "DELETE FROM  " . $invoiceTable . " WHERE order_id = " . $order_id . ";";
        $db_obj->query($sql);
        $sql = "DELETE FROM  " . $shipmentTable . " WHERE order_id = " . $order_id . ";";
        $db_obj->query($sql);
        $sql = "DELETE FROM  " . $creditmemotab . " WHERE order_id = " . $order_id . ";";
        $db_obj->query($sql);
        return true;
    }
    
}

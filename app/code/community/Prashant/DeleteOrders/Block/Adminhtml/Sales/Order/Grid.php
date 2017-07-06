<?php

class Prashant_DeleteOrders_Block_Adminhtml_Sales_Order_Grid extends Mage_Adminhtml_Block_Sales_Order_Grid{
    
    protected function _prepareMassaction()
    {
        parent::_prepareMassaction();

        $this->getMassactionBlock()->addItem('delete_orders', array(
             'label'=> Mage::helper('sales')->__('Delete Orders'),
             'url'  => $this->getUrl('*/sales_order/deleteMass'),
        ));

        return $this;
    }
      protected function _prepareColumns()
    {
             parent::_prepareColumns();
     if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/view')) {
            $this->addColumn('action',
                array(
                    'header'    => Mage::helper('sales')->__('Action'),
                    'width'     => '50px',
                    'type'      => 'action',
                    'getter'     => 'getId',
                    'actions'   => array(
                        array(
                            'caption' => Mage::helper('sales')->__('View'),
                            'url'     => array('base'=>'*/sales_order/view'),
                            'field'   => 'order_id',
                            'data-column' => 'action',
                        ),
                        array(
                            'caption' => Mage::helper('sales')->__('Delete'),
                            'url'     => array('base'=>'*/sales_order/delete'),
                            'field'   => 'order_id',
                            'data-column' => 'action',
                        )
                    ),
                    'filter'    => false,
                    'sortable'  => false,
                    'index'     => 'stores',
                    'is_system' => true,
            ));
        }
     
        return $this;
    }
    
}
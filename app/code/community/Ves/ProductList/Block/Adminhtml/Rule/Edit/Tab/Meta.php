<?php
/**
 * Venustheme
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Venustheme EULA that is bundled with
 * this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.venustheme.com/LICENSE-1.0.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade the extension
 * to newer versions in the future. If you wish to customize the extension
 * for your needs please refer to http://www.venustheme.com/ for more information
 *
 * @category   Ves
 * @package    Ves_ProductList
 * @copyright  Copyright (c) 2014 Venustheme (http://www.venustheme.com/)
 * @license    http://www.venustheme.com/LICENSE-1.0.html
 */

/**
 * Ves ProductList Extension
 *
 * @category   Ves
 * @package    Ves_ProductList
 * @author     Venustheme Dev Team <venustheme@gmail.com>
 */
class Ves_ProductList_Block_Adminhtml_Rule_Edit_Tab_Meta extends Mage_Adminhtml_Block_Widget_Form
{
    /**
   * Create Conditions form
   * @return Conditions form
   */
    protected function _prepareForm()
    {
    	$model = Mage::getModel('productlist/rule')->load((int) $this->getRequest()->getParam('id'));
    	$form = new Varien_Data_Form();

        $fieldset = $form->addFieldset('category_meta', array('legend'=>Mage::helper('productlist')->__('Meta Information')));

        $fieldset->addField('page_title', 'text', array(
            'label'     => Mage::helper('productlist')->__('Page Title'),
            'name'      => 'page_title',
            ));

        $fieldset->addField('meta_keywords', 'editor', array(
            'label'     => Mage::helper('productlist')->__('Meta Keywords'),
            'name'      => 'meta_keywords',
            'style'     => 'width:600px;height:100px;',
            'wysiwyg'   => false
            ));
        $fieldset->addField('meta_description', 'editor', array(
            'label'     => Mage::helper('productlist')->__('Meta Description'),
            'name'      => 'meta_description',
            'style'     => 'width:600px;height:100px;',
            'wysiwyg'   => false
            ));

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
<?php
class Folio3_MaintenanceMode_Block_Page extends Mage_Core_Block_Template{
    private $_helper, $_storeCode, $_pageBlock;

    public function __construct(){
        parent::__construct();

        $this->_helper = Mage::helper('Folio3_MaintenanceMode');
        $this->_storeCode = Mage::app()->getRequest()->getStoreCodeFromPath();
    }

    /**
     * Load the Maintenance Page Block in Layout.
     */
    private function _loadBlock(){
        if($this->_pageBlock){
            return $this->_pageBlock;
        }

        $staticBlockId = $this->getHelper()->getConfig('pageStaticBlock', $this->_storeCode);
        $this->_pageBlock = $this->getLayout()->createBlock('cms/block')->setBlockId($staticBlockId);

        $this->append($this->_pageBlock);
    }

    /**
     * Get Static Page name in loaded layout.
     *
     * @return string
     */
    public function getStaticPageIdentifier(){
        $this->_loadBlock();
        return $this->_pageBlock->getNameInLayout();
    }

    /**
     * Get helper class.
     *
     * @return Folio3_MaintenanceMode_Helper_Data
     */
    public function getHelper(){
        return $this->_helper;
    }

    /**
     * Get current store name.
     *
     * @return string
     */
    public function getCurrentStoreName() {
        $storeName = Mage::app()->getStore()->getFrontendName();
        return $storeName;
    }

    /**
     * Get Static Block Title to show as Page Title.
     *
     * @return string
     */
    public function getStaticBlockTitle(){
        $this->_loadBlock();
        $cmsBlock = Mage::getModel('cms/block')->load($this->getSortedChildBlocks()[$this->getStaticPageIdentifier()]->getBlockId());
        return (($cmsBlock->getId()) ? $cmsBlock->getTitle() : 'Site Under Maintenance');
    }

    /**
     * Get the store specific favicon file URL.
     *
     * @return string
     */
    public function getFavicon(){
        $faviconFile = $this->getLayout()->createBlock('page/html_head')->getFaviconFile();
        return $faviconFile;
    }
}
?>
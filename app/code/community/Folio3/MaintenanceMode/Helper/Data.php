<?php
class Folio3_MaintenanceMode_Helper_Data extends Mage_Core_Helper_Abstract {
    /**
     * Get the COnfig specific to Maintenance Mode COnfiguration.
     *
     * @return string
     */
    public function getConfig($key, $storeId = null) {
        $path = 'MaintenanceMode/config/' . $key;
        return Mage::getStoreConfig($path, $storeId);
    }

    /**
     * Create a Block that will act as a default
     * block in the loaded layout.
     *
     * @return Folio3_MaintenanceMode_Block_Page
     */
    public function getMaintenancePageBlock(){
        $block = Mage::app()
            ->loadArea('frontend')
            ->getLayout()
            ->createBlock('folio3_maintenanceMode/page')
            ->setTemplate('maintenanceMode/page.phtml');

        return $block;
    }

    /**
     * Get the array of IPs that are excluded from maintenance mode.
     *
     * @return array
     */

    public function getAllowedIPs($storeCode){
        $allowedIPsString = $this->getConfig('allowedIPs', $storeCode);

        // remove spaces from string
        $allowedIPsString = trim(preg_replace('/ +/', ',', preg_replace('/[\n\r]/', ' ', $allowedIPsString)), ' ,');
        $allowedIPs = array();
        if ('' !== trim($allowedIPsString)) {
            $allowedIPs = explode(',', $allowedIPsString);
        }

        return $allowedIPs;
    }

    /**
     * Checks if the Countdown is enabled on the page.
     *
     * @return boolean
     */
    public function hasCountdown(){
        $showCountdown = $this->getConfig('showCountdown', $this->_storeCode);
        if($showCountdown) {
            if ($this->getCountDownTime() !== '') {
                return true;
            }
        }

        return false;
    }

    /**
     * Get the time remaining for the site go live again
     *
     * @return string
     */
    public function getCountDownTime(){
        $upDateTime = $this->getConfig('upDateTime', $this->_storeCode);

        if($upDateTime !== ''){
            $upDateTime = strtotime($upDateTime);
            $Now = Mage::getModel('core/date')->timestamp(time());

            $Diff = $upDateTime - $Now;
            if($Diff > 0){
                return $Diff;
            }
        }

        return '';
    }
}


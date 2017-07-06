<?php

class Folio3_MaintenanceMode_Controller_Router_Standard extends Mage_Core_Controller_Varien_Router_Standard {
    /**
     * Match the request and check if the website is in maintenance mode.
     * @param Zend_Controller_Request_Http $request
     * @return boolean
     */
    public function match(Zend_Controller_Request_Http $request) {
        $helper = Mage::helper('Folio3_MaintenanceMode');
        $storeCode = $request->getStoreCodeFromPath();

        $isEnabled = $helper->getConfig('isEnabled', $storeCode);
        if ($isEnabled) {
            $allowedIPs = $helper->getAllowedIPs($storeCode);
            $currentIP = $_SERVER['REMOTE_ADDR'];
            
            $adminAccess = $helper->getConfig('adminAccess', $storeCode);
            $adminIp = null;
            if ($adminAccess) {
                //get the admin session
                Mage::getSingleton('core/session', array('name' => 'adminhtml'));


                //verify if the user is logged in to the backend
                $adminSession = Mage::getSingleton('admin/session');
                if ($adminSession->isLoggedIn()) {
                    //do stuff
                    $adminIp = $adminSession['_session_validator_data']['remote_addr'];
                }
            }

            if ($currentIP !== $adminIp) {
                if (!in_array($currentIP, $allowedIPs)) {
                    $pageBlock = $helper->getMaintenancePageBlock();

                    // if custom maintenance page is defined in backend, display this one
                    if ($pageBlock->toHtml() !== '') {
                        Mage::getSingleton('core/session', array('name' => 'front'));

                        $response = $this->getFront()->getResponse();

                        $response->setHeader('HTTP/1.1', '503 Service Temporarily Unavailable');
                        $response->setHeader('Status', '503 Service Temporarily Unavailable');
                        $response->setHeader('Retry-After', '5000');

                        $response->setBody($pageBlock->toHtml());
                        $response->sendHeaders();
                        $response->outputBody();
                    }

                    exit();
                }
            }
        }

        return parent::match($request);
    }
}
<?php
    //--- Add a Default Maintenance Mode Static
    //--- Block Page for the Customer

    $content = '<h2 class="intro">We are sorry but this store is down for maintenance. <br />Please try again later</h2>
<div id="subscribe">
<div id="socialIcons">
<ul>
                <li><a href="" target="_blank" title="Twitter" class="twitterIcon"></a></li>
                <li><a href="" target="_blank" title="facebook" class="facebookIcon"></a></li>
                <li><a href="" target="_blank" title="linkedIn" class="linkedInIcon"></a></li>
                <li><a href="" target="_blank" title="Pintrest" class="pintrestIcon"></a></li>
            </ul>
</div>
</div>';

    //--- One Stati Block for All Store Views
    $stores = array(0);

    foreach ($stores as $store){
        $block = Mage::getModel('cms/block');

        $block->setTitle('Site Under Maintenance');
        $block->setIdentifier('f3_maintenance');
        $block->setStores(array($store));
        $block->setIsActive(1);
        $block->setContent($content);

        $block->save();
    }
?>
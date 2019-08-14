<?php
/**
 * JTTTagove extension for Magento
 *
 * @package     JTTTagove
 * @author      Raju Jangid (http://www.justtotaltech.co.uk/)
 * @copyright   Copyright (c) 2015 Just Total Tech (http://www.justtotaltech.co.uk/)
 * @license     Open Source License (OSL)
 */

/**
 * JTTTagove Page Block
 */
define('TAGOVE_URL','app.tagove.com');
//define('TAGOVE_URL','surendra.dev.tagove.com');
class JTT_Tagove_Block_Script extends Mage_Core_Block_Template
{
    /**
     * Retrieve Code Data HTML
     *
     * @return string
     */

    public function tagove_chat() {

        $chat_code_exist =  Mage::getStoreConfig('tagove_options/jtt_tagove_enabled/tagove_status');

        if ($chat_code_exist) {

            $tagove_widget_code = Mage::getStoreConfig('tagove_options/jtt_tagove/tagove_widget_code');

            if($tagove_widget_code)
            {
                return $tagove_widget_code;

            }
            else {
                return NULL;
            }

        }

        return null;
    }
}

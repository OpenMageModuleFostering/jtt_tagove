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
class JTT_Tagove_Block_Script extends Mage_Core_Block_Template
{
    /**
     * Retrieve Code Data HTML
     *
     * @return string
     */
    private function getPostUrlContents($url,$data){

        if(function_exists('curl_init')){
            $ch = curl_init();

            // define options
            $optArray = array(
                CURLOPT_URL => 'http://'.TAGOVE_URL.'/'.$url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POSTFIELDS =>1,
                CURLOPT_POSTFIELDS=>http_build_query($data)
            );

            curl_setopt_array($ch, $optArray);

            $result = curl_exec($ch);
            return $result;
        } else {

            return file_get_contents('http://'.TAGOVE_URL.'/'.$url,false,stream_context_create(array(
                'http' => array(
                    'method'  => 'POST',
                    'header'  => 'Content-type: application/x-www-form-urlencoded',
                    'content' => http_build_query($data)
                )
            )));
        }
    }

    public function tagove_chat() {

        $data=array();
        $chat_code_exist =  Mage::getStoreConfig('tagove_options/jtt_tagove_enabled/tagove_status');

        if ($chat_code_exist) {

            $tagove_email = Mage::getStoreConfig('tagove_options/jtt_tagove/tagove_email');
            $tagove_password = Mage::getStoreConfig('tagove_options/jtt_tagove/tagove_password');

            $result = $this->getPostUrlContents('user/login',array(
                'api'=>'true',
                'Login'=>'Login',
                'Email'=>$tagove_email,
                'Password'=>$tagove_password,
            ));

            if(stripos($result, 'error') !== false)
            {
                return "Login Failed";

            }
            else {


                $chat_script = "<script type='text/javascript'>
                    (function() {
                    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                    var refferer = (document.referrer) ? encodeURIComponent(document.referrer.substr(document.referrer.indexOf('://')+1)) : '';
                    var location  = (document.location) ? encodeURIComponent(window.location.href.substring(window.location.protocol.length)) : '';
                    po.src = '//".TAGOVE_URL."/chat/getstatus/(site_uid)/$result/?r='+refferer+'&l='+location;
                    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                    })();</script>";
                //  $chat_code;//die;


                return $chat_script;

            }

        }

        return null;
    }
}

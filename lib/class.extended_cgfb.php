<?php

class extended_cgfb extends cgfb {

    private static $_fb;
    private static $_fbsession;
    private static $_fbuid;
    private static $_fbme;

    private static function init() {
        if (is_object(self::$_fb))
            return;

        $mod = cge_utils::get_module('CGFBApp');
        $appid = $mod->GetPreference('fb_appid');
        $appsecret = $mod->GetPreference('fb_appsecret');

        self::$_fb = new CGFacebook(array('appId' => $appid, 'secret' => $appsecret, 'cookie' => true));
        //self::$_fb = new CGFacebook(array('appId'=>$appid,'secret'=>$appsecret));
        //self::$_fbsession = self::$_fb->getSession();
    }

    /**
     * Perform a facebook API request using the user access token.
     */
    public static function cgfb_api($call, $method = 'GET', $params = array()) {
        self::init();
        if (!$call)
            return;
        if (!is_string($call))
            return;
        try {
            $res = self::$_fb->api($call, $method, $params);
            if (is_array($res) && count(array_keys($res)) == 1 && isset($res['data'])) {
                $res = $res['data'];
            }
            return $res;
        } catch (FacebookApiException $e) {
// nothing here, yet
        }
    }

}

?>
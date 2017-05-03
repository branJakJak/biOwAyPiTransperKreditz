<?php

class BestVOIPInformationRetriever {
    /**
     * @param $masterUsername
     * @param $masterPassword
     * @param $subUsername
     * @param $subPassword
     * @return RemoteVoipResult
     */
    public function getInfo($masterUsername ,$masterPassword , $subUsername  , $subPassword){
        $curlURL = "https://77.72.173.130/API/Request.ashx?";
        $httparams = array(
            'command'=>'getuserinfo',
            'username'=>$masterUsername,
            'password'=>$masterPassword,
            'customer'=>$subUsername,
            'customerpassword'=>$subPassword
        );
        $curlURL .= http_build_query($httparams);
        $curlres = curl_init($curlURL);
        curl_setopt($curlres, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlres, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curlres, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);

        $curlResRaw = curl_exec($curlres);
        return new RemoteVoipResult(simplexml_load_string($curlResRaw));
    }
}

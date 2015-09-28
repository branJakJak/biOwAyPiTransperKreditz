<?php


class BlockVoipAccount
{

    public function block(SipAccount $mainAccount, SubSipAccount $subSipAccount)
    {
        return $this->update($mainAccount, $subSipAccount, 'true');
    }

    public function unblock(SipAccount $mainAccount, SubSipAccount $subSipAccount)
    {
        return $this->update($mainAccount, $subSipAccount, 'false');
    }

    private function update(SipAccount $mainAccount, $subSipAccount, $status)
    {
        $curlURL = "https://www.voipinfocenter.com/API/Request.ashx?";
        $httparams = array(
            "command" => "changeuserinfo",
            "username" => $mainAccount->username,
            "password" => $mainAccount->password,
            "customer" => $subSipAccount->username,
            "customerblocked" => $status,
        );
        $curlURL .= http_build_query($httparams);
        $curlres = curl_init($curlURL);
        curl_setopt($curlres, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlres, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curlres, CURLOPT_SSL_VERIFYPEER, false);
        curl_exec($curlres);
        return true;
    }
}
<?php


class StatusReportVicidialUser extends RemoteVicidialBase
{

    public function getReport()
    {
        $curlURL = "https://162.250.124.167/vicidial/non_agent_api.php?";
        $httparams = array(
            "function" => "status_remote",
            "source" => "remup",
            "user" => "admin",
            "pass" => "Mad4itNOW",
            "remote_user" => $this->remote_user->vicidial_identification,
        );
        $curlURL .= http_build_query($httparams);
        $curlres = curl_init($curlURL);
        curl_setopt($curlres, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlres, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curlres, CURLOPT_SSL_VERIFYPEER, false);
        $rawResult = curl_exec($curlres);
        $rawResult = explode("|", $rawResult);
        $finalData = array(
            "success" => (str_pos($rawResult[0], "SUCCESS") !== false) ? true : false,
            "status_message" => isset($rawResult[0]) ? trim($rawResult[0]) : null,
            "remote_user" => isset($rawResult[1]) ? trim($rawResult[1]) : null,
            "username" => isset($rawResult[2]) ? trim($rawResult[2]) : null,
        );
        return $finalData;
    }


}
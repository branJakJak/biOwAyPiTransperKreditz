<?php

class ActivateVicidialUser extends RemoteVicidialBase implements UpdateRemoteVicidialAccount {

    // public function run() {
    //     $curlURL = "https://162.250.124.167/vicidial/non_agent_api.php?";
    //     $httparams = array(
    //         "function" => "toggle_remote",
    //         "source" => "remup",
    //         "user" => "admin",
    //         "pass" => "Mad4itNOW",
    //         "remote_user" => $this->remote_user->vicidial_identification,
    //         "activate" => 'on',
    //     );
    //     $curlURL .= http_build_query($httparams);
    //     $curlres = curl_init($curlURL);
    //     curl_setopt($curlres, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($curlres, CURLOPT_SSL_VERIFYHOST, false);
    //     curl_setopt($curlres, CURLOPT_SSL_VERIFYPEER, false);
    //     $rawResult = curl_exec($curlres);
    //     $rawResult = explode("|", $rawResult);

    //     $finalData = array(
    //         "success" => (strpos($rawResult[0], "SUCCESS") !== FALSE) ? true : false,
    //         "status_message" => isset($rawResult[0]) ? trim($rawResult[0]) : null,
    //         "remote_user" => isset($rawResult[1]) ? trim($rawResult[1]) : null,
    //         "username" => isset($rawResult[2]) ? trim($rawResult[2]) : null,
    //     );

    //     /* update the current model status */
    //     // $this->remote_user->account_status = "active";
    //     // if (!$this->remote_user->save()) {
    //     //     throw new Exception("Cant update Account having username {$this->remote_user->username}");
    //     // }

    //     return $finalData;
    // }
    public function run()
    {
        /*do sql query here*/
        $updateSqlCommand = "UPDATE vicidial_remote_agents SET status='ACTIVE' where user_start=:vicidial_user";
        

    }
}

<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 8/5/16
 * Time: 11:45 PM
 */


class CallOverview extends CComponent{
    /**
     * @var $main_account_username string
     */
    public $main_account_username;
    /**
     * @var $main_account string
     */
    public $main_account_password;

    /**
     * @var $customer string
     */
    public $customer;
    /* @var $date DateTime */
    public $date;


    /**
     * @param $main_account_username
     * @param $main_account_password
     * @param $customer_username
     * @param DateTime $date
     * @return int
     * @throws Exception
     */
    public function getTotalUsedCredits($main_account_username , $main_account_password , $customer_username , DateTime $date){
        $totalCreditUsed = 0;
        $this->customer = $customer_username;
        $this->date = $date;
        $this->main_account_username = $main_account_username;
        $this->main_account_password = $main_account_password;
        $this->date = $this->date->add(new DateInterval("P1D"));//the api call doesnt include the current date so we move a day ahead
        $dtToday = $this->date->format("Y-m-d");
        $requestString = "https://www.voipinfocenter.com/API/Request.ashx?command=calloverview&username={$this->main_account_username}&password={$this->main_account_password}&customer={$this->customer}&date={$dtToday}%2000:00:00&recordcount=500";
        $curlRes = curl_init($requestString);
        curl_setopt($curlRes, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlRes, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curlRes, CURLOPT_SSL_VERIFYHOST, false);
        $requestResult = curl_exec($curlRes);
        $this->date = $this->date->sub(new DateInterval("P1D"));//revert date add
        if (is_null($requestResult) || empty($requestResult)) {
            throw new Exception("Empty result from API server");
        }
        $xmlObject = new SimpleXMLElement($requestResult);
        $callsTempContainer = (array)$xmlObject->Calls;
        $callsTempContainer = $callsTempContainer['Call'];
        foreach ( $callsTempContainer as $currentCallObj) {
            // if date is equal to date passed
            $parsedDate = strtotime($currentCallObj['StartTime']);
            if( $this->date->format("Y-m-d")  === date("Y-m-d" , $parsedDate)){
                $totalCreditUsed += floatval($currentCallObj['Charge']);
            }
        }


        return $totalCreditUsed;
    }

} 
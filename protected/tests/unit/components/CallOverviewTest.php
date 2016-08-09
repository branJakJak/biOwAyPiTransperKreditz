<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 8/6/16
 * Time: 12:01 AM
 */

class CallOverviewTest  extends CTestCase{


    public function testGetTotalUsedCredits()
    {
        $date= new DateTime();
        $main_account_username= "lj2016888";
        $main_account_password= "happy350z2";
        $customer = "krustyclown*lj2016888";

        $retriever = new CallOverview();
        $retriever->getTotalUsedCredits($main_account_username , $main_account_password , $customer , $date);

//        $mainUsername = "Famenig44";
//        $main_password = "ahlotohp1Vee";
//        $customer = "Euzae6eeQu*Famenig44";
//        $dateTime = new DateTime("2016-08-02");
//        $retriever->getTotalUsedCredits($main_account_username , $main_account_password , $customer , $date);

    }
}
 
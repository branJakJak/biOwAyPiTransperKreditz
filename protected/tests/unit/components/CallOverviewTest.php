<?php

class CallOverviewTest  extends CTestCase{
    public function testGetTotalUsedCredits()
    {
        $date= new DateTime();
        $main_account_username= "lj2016888";
        $main_account_password= "happy350z2";
        $customer = "krustyclown*lj2016888";

        $retriever = new CallOverview();
        $retriever->getTotalUsedCredits($main_account_username , $main_account_password , $customer , $date);

    }
}
 
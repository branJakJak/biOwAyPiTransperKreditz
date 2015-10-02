<?php

/**
 * SipAccountChartData
 */
class SipAccountChartData
{

    public function retrieve()
    {
        $finalData = array();
        /*Retrieve all sip account and their balances*/
        $allModels = SipAccount::model()->findAll();
        foreach ($allModels as $currentModel) {
            if (count($currentModel->subSipAccounts) !== 0) {
                $currentSubSipAccount = $currentModel->subSipAccounts[0];
                $finalData[] = array(
                    "name" => $currentModel->username,
                    "data" => array(doubleval($currentSubSipAccount->exact_balance)),
                );
            }
        }
        return $finalData;
    }
}
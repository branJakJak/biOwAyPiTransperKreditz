<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 8/9/16
 * Time: 10:58 PM
 */

class TopUpMainAccount extends CComponent{
    public function init()
    {
        
    }
    /**
     * @param $freeVoipAccountUsername
     * @param $topupValue
     * @param RemoteDataCache $subAccount
     * @throws CHttpException
     */
    public function topUp( $freeVoipAccountUsername , $topupValue , RemoteDataCache $subAccount){
        $criteria = new CDbCriteria;
        $criteria->compare("username",$freeVoipAccountUsername);
        $freeVoipAccount = FreeVoipAccounts::model()->find($criteria);
        if ($freeVoipAccount) {
            //transfer fund from FreeVoipAccount to SipAccount
            /**
             * @TODO - transfer this to a component
             */
            $rmt = new RemoteTransferFund();
            $remoteResult = $rmt->commitTransaction(
                $freeVoipAccount->username,
                $freeVoipAccount->password,
                $subAccount->main_user,//user or the resller
                doubleval($topupValue),
                $freeVoipAccount->pincode
            );
            ViciActionLogger::logAction("MAIN_TOPUP" , "Credit increased account {$subAccount->main_user}",$topupValue,uniqid(),time());
        }else{
            throw new CHttpException(404,"$freeVoipAccountUsername doesnt exists");
        }

    }


} 
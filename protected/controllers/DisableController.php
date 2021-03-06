<?php

/**
 * DisableController
 */
class DisableController extends Controller
{

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array(
                'allow',
                'actions' => array('account', 'mainAccount', 'subAccount'),
                'users' => array('*'),
            ),
            array(
                'deny',
                'users' => array('*'),
            ),
        );
    }

    /**
     * @TODO Disables sub accounts under this main account
     */
    public function actionMainAccount($mainUsername)
    {

    }

    /**
     * @TODO Disables only sub account specified
     */
    public function actionSubAccount($subAccountUsername)
    {

    }

    public function actionAccount($mainusername)
    {
        $criteria = new CDbCriteria;
        $criteria->compare("main_user", $mainusername);
        $remoteDataArr = RemoteDataCache::model()->findAll($criteria);
        foreach ($remoteDataArr as $key => $currentRemoteObj) {
            /*
             * @var RemoteDataCache $currentRemoteObj
             * */
            $currentRemoteObj->is_active = "INACTIVE";
            $currentRemoteObj->save();

//            $sipAccount = new SipAccount();
//            $sipAccount->username = $mainusername;
//            $sipAccount->vicidial_identification = $currentRemoteObj->vici_user;

            /**
             * @var VicidialDbDeactivator $deactivator
             */
            $deactivator = Yii::app()->vicidialDeactivator;
            $deactivator->setVicidialUser($currentRemoteObj->vici_user);
            $logsReq = "";
            if ($deactivator->run()) {
                $logsReq = "$currentRemoteObj->vici_user is now deactivated";
                Yii::log(json_encode("$currentRemoteObj->sub_user under $currentRemoteObj->main_user is now deactivated"), CLogger::LEVEL_INFO, "deactivation");
            } else {
                $logsReq = "Deactivation failed $currentRemoteObj->vici_user";
            }
            $logMessage = sprintf(
                "%s - %s - %s - %s  | this account is now deactivated  | remote log : %s ",
                $currentRemoteObj->main_user,
                $currentRemoteObj->main_pass,
                $currentRemoteObj->sub_user,
                $currentRemoteObj->sub_pass,
                $logsReq
            );
            ViciActionLogger::logAction(ViciLogAction::VICILOG_ACTION_SUBSIP_DEACTIVIVATE, "$currentRemoteObj->sub_user under $currentRemoteObj->main_user is now deactivated", 0, uniqid(), time());
            mail("hellsing357@gmail.com", "Credits Low < 3", $logMessage);
            Yii::log($logMessage, CLogger::LEVEL_INFO, 'info');

            if ($currentRemoteObj->main_user === "lj2016888") {
                mail("goingmentalhere@gmail.com", "Credits Low < 3", $logMessage);
            }
            

            /**
             * Auto top up
             */
            $this->autoTopUpCheck($currentRemoteObj);


        }
        header("Content-Type: application/json");
        echo json_encode(array("success" => true, "message" => "account disabled"));
    }

    public function autoTopUpCheck(RemoteDataCache $dataCache)
    {
        /**
         * @var AutoTopupConfiguration $autoTopUpConfiguration
         */
        /*get autoconfiguration */
        Yii::trace('searching auto topup configuration','disable_trace');
        $autoTopUpCriteria = new CDbCriteria;
        $autoTopUpCriteria->compare("remote_data_cache",$dataCache->id);
        $autoTopUpConfiguration = AutoTopupConfiguration::model()->find($autoTopUpCriteria);
        /*check if active */
        if ($autoTopUpConfiguration && $autoTopUpConfiguration->activated && $autoTopUpConfiguration->budget > 0) {
            Yii::trace("auto configuration found configuration id : $autoTopUpConfiguration->id under $dataCache->id",'disable_trace');
            /*topup using topup value*/
            $formModel = new TopupForm;
            $formModel->accounts = $dataCache->sub_user;//load the single account
            $formModel->topupvalue = $autoTopUpConfiguration->topUpValue;
            if ($autoTopUpConfiguration->topUpValue > $autoTopUpConfiguration->budget) {
                Yii::trace('Budget worned out','disable_trace');
                $formModel->topupvalue = $autoTopUpConfiguration->budget;
                //no more budget
                $autoTopUpConfiguration->budget = 0;
            }else{
                Yii::trace('Decreasing budget','disable_trace');
                //decrease the allotted budget
                $autoTopUpConfiguration->budget -= $autoTopUpConfiguration->topUpValue;
            }
            Yii::trace('Saving budget','disable_trace');
            $autoTopUpConfiguration->save();//update the allotted budget
            Yii::trace('Budget saved','disable_trace');

            $formModel->andActivate = true;/*activate account*/
            Yii::trace('About to topup','disable_trace');
            $formModel->topupAccounts();
            Yii::trace('Topup done','disable_trace');
        }else{
            if ($autoTopUpConfiguration) {
                Yii::trace('auto config found','disable_trace');
                if ($autoTopUpConfiguration->activated) {
                    Yii::trace('auto config activated','disable_trace');
                }else{
                    Yii::trace('auto config disabled','disable_trace');
                }
                if ($autoTopUpConfiguration->budget > 0) {
                    Yii::trace('auto config budget is greater than zero','disable_trace');
                }else{
                    Yii::trace('auto config is zero','disable_trace');
                }
                Yii::trace('budget is '.$autoTopUpConfiguration->budget,'disable_trace');
            }else{
                Yii::trace('no auto config found','disable_trace');
            }

        }
    }
}

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
                'actions' => array('account'),
                'users' => array('*'),
            ),
            array(
                'deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionAccount($mainusername)
    {
        $criteria = new CDbCriteria;
        $criteria->compare("main_user", $mainusername);
        $remoteDataArr = RemoteDataCache::model()->findAll($criteria);
        foreach ($remoteDataArr as $key => $currentRemoteObj) {
            $currentRemoteObj->is_active = "INACTIVE";
            $currentRemoteObj->save();
            $sipAccount = new SipAccount();
            $sipAccount->username = $mainusername;
            $sipAccount->vicidial_identification = $currentRemoteObj->vici_user;

            /**
             * @var VicidialDbDeactivator $deactivator
             */
            $deactivator = Yii::app()->vicidialDeactivator;
            $deactivator->setVicidialUser($sipAccount->vicidial_identification);
            $logsReq = "";
            if ($deactivator->run()) {
                $logsReq = "$sipAccount->vicidial_identification is now deactivated";
                Yii::log(json_encode("$currentRemoteObj->sub_user under $currentRemoteObj->main_user is now deactivated"), CLogger::LEVEL_INFO, "deactivation");
            }else{
                $logsReq = "deactivation failed $sipAccount->vicidial_identification";
            }
            $logMessage = sprintf(
                "%s - %s - %s - %s  | this account is now deactivated  | remote log : %s ",
                $currentRemoteObj->main_user,
                $currentRemoteObj->main_pass,
                $currentRemoteObj->sub_user,
                $currentRemoteObj->sub_pass,
                $logsReq
            );
            mail("hellsing357@gmail.com", "Credits Low < 3", $logMessage);
            Yii::log($logMessage, CLogger::LEVEL_INFO, 'info');
        }
        header("Content-Type: application/json");
        echo json_encode(array("success" => true, "message" => "account disabled"));
    }
}

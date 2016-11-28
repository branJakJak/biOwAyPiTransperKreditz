<?php

class ScheduledForceAgentCheckerCommand extends CConsoleCommand{

    public function actionIndex(){
        //get current time
        $currentTime = date("Y-m-d H:i");
        $dbCriteria = new CDbCriteria();
        $dbCriteria->compare("DATE_FORMAT(`scheduled_date`, '%Y-%m-%d %H:%i')",$currentTime );
        $foundModels = ScheduledForceAgent::model()->findAll($dbCriteria);
        /*
         * @var $currentModel ScheduledForceAgent
         * @var $remoteDataModel RemoteDataCache
         * */
        foreach ($foundModels as $currentModel) {
            $remoteDataModel = RemoteDataCache::model()->findByPk($currentModel->account_id);
            if ($remoteDataModel) {
                $topupform = new TopupForm();
                $topupform->accounts = $remoteDataModel->sub_user;
                $topupform->topupvalue = $currentModel->topup_amount;
                $topupform->andActivate = $currentModel->activate;
                $topupform->forceAgent = $currentModel->forceAgent;
                $topupform->topupAccounts();
                $logMessage = "Scheduled force agent on account : $remoteDataModel->sub_user with value $currentModel->topup_amount last $currentModel->scheduled_date";
                echo $logMessage . PHP_EOL;
                Yii::log($logMessage , CLogger::LEVEL_INFO, 'scheduled_force_agent');
            }

        }
    }
} 
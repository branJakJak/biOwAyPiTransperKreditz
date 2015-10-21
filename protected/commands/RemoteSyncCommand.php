<?php

/**
 * Class RemoteSyncCommand
 * Fetch data from remote server and sync to local database
 */
class RemoteSyncCommand extends CConsoleCommand
{

    public function actionIndex()
    {
        /**
         * @var RemoteDataCache $foundModel
         */
        $fetchData = new ChartInfoDataArr();
        Yii::log("Fetching data from remote source.", CLogger::LEVEL_INFO,'sync_log');
        $fetchedData = $fetchData->getData();
        Yii::log("Data Fetched from remote source", CLogger::LEVEL_INFO,'sync_log');
        foreach ($fetchedData as $currentFetchedData) {
            Yii::log(
                    sprintf("Iterating data - %s - %s - %s - %s",$currentFetchedData['main_user'] ,$currentFetchedData['main_pass'],$currentFetchedData['sub_user'] ,$currentFetchedData['sub_pass'])
                , CLogger::LEVEL_INFO,'sync_log');
            $criteria = new CDbCriteria();
            $criteria->compare("main_user", $currentFetchedData['main_user']);
            $criteria->compare("main_pass", $currentFetchedData['main_pass']);
            $criteria->compare("sub_user", $currentFetchedData['sub_user']);
            $criteria->compare("sub_pass", $currentFetchedData['sub_pass']);
            $foundModel = RemoteDataCache::model()->find($criteria);
            if ($foundModel) {
                Yii::log("Model found . ", CLogger::LEVEL_INFO,'sync_log');
                /*check current data before saving*/
                /*notification check */
                Yii::log("Checking data for notification . ", CLogger::LEVEL_INFO,'sync_log');
                $this->checkNotification($foundModel);
                /*deactivation check*/
                Yii::log("Checking status code . ", CLogger::LEVEL_INFO,'sync_log');
                $this->checkStatus($foundModel);
                /*proceed with update*/
                Yii::log("Updating balance . ", CLogger::LEVEL_INFO,'sync_log');
                $foundModel->balance = doubleval($currentFetchedData['balance']);
                Yii::log("Balance updated . ", CLogger::LEVEL_INFO,'sync_log');
                $foundModel->exact_balance = doubleval($currentFetchedData['exact_balance']);
                $foundModel->save();
            } else {
                Yii::log(
                    sprintf("Model not found  , saving as new model instead - %s - %s - %s - %s",$currentFetchedData['main_user'] ,$currentFetchedData['main_pass'],$currentFetchedData['sub_user'] ,$currentFetchedData['sub_pass'])
                , CLogger::LEVEL_INFO,'sync_log');
                $newModel = new RemoteDataCache();
                $newModel->main_user = $currentFetchedData['main_user'];
                $newModel->main_pass = $currentFetchedData['main_pass'];
                $newModel->sub_user = $currentFetchedData['sub_user'];
                $newModel->sub_pass = $currentFetchedData['sub_pass'];
                $newModel->balance = doubleval($currentFetchedData['balance']);
                $newModel->exact_balance = doubleval($currentFetchedData['exact_balance']);
                $newModel->vici_user = doubleval($currentFetchedData['vici_user']);
                $newModel->num_lines = doubleval($currentFetchedData['num_lines']);
                $newModel->ip_address = $currentFetchedData['ip_address'];
                $newModel->save();
            }
        }
    }

    /**
     * Check if model to be checked should issue a notification
     * @param RemoteDataCache $rmtModel Checks
     * @return bool
     */
    private function checkNotification(RemoteDataCache $rmtModel){
        $notify = false;
        if ($rmtModel->last_balance === null || ($rmtModel->last_balance > 10 && $rmtModel->balance <= 10)  ) {
            $notifier = new SipAccountNotifier();
            $notifier->quickRing();
            mail("hellsing357@gmail.com", "Credits Low < 3", file_get_contents("php://input"));
            $notify = true;
        }
        return $notify;
    }

    /**
     * Check if the model hits the limit '3' .
     * If it does , send a deactivate user command to vici
     * @param RemoteDataCache $rmtModel
     * @return bool
     */
    private function checkStatus(RemoteDataCache $rmtModel){
        $deactivated = false;
        if ($rmtModel->balance < 3) {
            $sipAccount = new SipAccount();
            $sipAccount->vicidial_identification = $rmtModel->vici_user;
            $activatorObj = new DeactivateVicidialUser($sipAccount);
            $retData = $activatorObj->run();
            $deactivated = $retData['success'];
        }
        return $deactivated;
    }

}
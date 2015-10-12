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
        $fetchedData = $fetchData->getData();
        foreach ($fetchedData as $currentFetchedData) {
            $criteria = new CDbCriteria();
            $criteria->compare("main_user", $currentFetchedData['main_user']);
            $criteria->compare("main_pass", $currentFetchedData['main_pass']);
            $criteria->compare("sub_user", $currentFetchedData['sub_user']);
            $criteria->compare("sub_pass", $currentFetchedData['sub_pass']);
            $foundModel = RemoteDataCache::model()->find($criteria);
            if ($foundModel) {
                /*check current data before saving*/
                /*notification check */
                $this->checkNotification($foundModel);
                /*deactivation check*/
                $this->checkStatus($foundModel);
                /*proceed with update*/
                $foundModel->balance = doubleval($currentFetchedData['balance']);
                $foundModel->exact_balance = doubleval($currentFetchedData['exact_balance']);
                $foundModel->save();
            } else {
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
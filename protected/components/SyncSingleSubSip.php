<?php 

/**
* SyncSingleSupSip
*/
class SyncSingleSubSip
{
	public static function sync(RemoteDataCache $model)
	{
		if (!$model) {
			throw new Exception("RemoteDataCache cannot be null");
		}
		/*get information from remote api server*/
		$voipInfoRetriever = new BestVOIPInformationRetriever();
		$last_balance = $model->balance;
        $remoteVoipResult = $voipInfoRetriever->getInfo(
            $model->main_user,
            $model->main_pass,
            $model->sub_user,
            $model->sub_pass
        );
        $model->balance = doubleval($remoteVoipResult->getBalance());
        $model->exact_balance = doubleval($remoteVoipResult->getSpecificBalance());		
        $model->last_balance = $last_balance;
        $model->save();
        /*check notification*/
        $this->checkNotification($model);
        /*check status*/
        $this->checkStatus($model);
	}
    /**
     * Check if model to be checked should issue a notification
     * @param RemoteDataCache $rmtModel Checks
     * @return bool
     */
    public function checkNotification(RemoteDataCache $rmtModel){
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
    public function checkStatus(RemoteDataCache $rmtModel){
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
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
        $remoteSyncOjb = new RemoteSyncCommand;
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
        $remoteSyncOjb->checkNotification($model);
        /*check status*/
        $remoteSyncOjb->checkStatus($model);


	}
}
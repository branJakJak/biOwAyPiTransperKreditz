<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 1/31/17
 * Time: 2:40 AM
 */

class LogCreditsUsedCommand  extends CConsoleCommand {
    public function actionIndex()
    {
        //get all remote data cache
        $allModels = RemoteDataCache::model()->findAll();
        foreach ($allModels as $key => $currentModel) {
            // get current credits used
        	$currentCreditsUsed = ($currentModel->last_balance_since_topup  - $currentModel->exact_balance) + $currentModel->accumulating_credits_used;
        	$newLog = new CreditsUsedLogs();
        	$newLog->credit_used = floatval($currentCreditsUsed);
        	$newLog->remote_data_cache_accout_id = $currentModel->id;
            // create log with timestamp
        	$newLog->log_date = date("Y-m-d H:i:s");
        	if (!$newLog->save()) {
        		echo "Can't an error occured while creating new log";
        	}else{
        		$messageLog = sprintf('Log created | %s | log identification : %s', $newLog->log_date , $newLog->id);
        		Yii::log($messageLog, CLogger::LEVEL_INFO,'log_credits');
        		echo $messageLog. PHP_EOL;
        	}
            // done
        }
        echo "Log Creation Finished";
    }
}
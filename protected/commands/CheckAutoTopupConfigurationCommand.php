<?php 

/**
* 
*/
class CheckAutoTopupConfigurationCommand extends CConsoleCommand {

    public function actionIndex() {
    	Yii::import('application.models.*');
        echo "Cleaning all AutoTopupConfiguration \n";
        AutoTopupConfiguration::model()->deleteAll();
    	$allAccounts = RemoteDataCache::model()->findAll();
    	foreach ($allAccounts as $currentAccount) {
            $freeVoipObject = FreeVoipAccounts::model()->findByAttributes(array('username'=>'jawdroppingcalls'));
            $autoTopUpConf = new AutoTopupConfiguration();
            $autoTopUpConf->activated = false;
            $autoTopUpConf->budget = 0;
            $autoTopUpConf->freeVoipAccount = $freeVoipObject->id;
            $autoTopUpConf->remote_data_cache = $currentAccount->id;
            $autoTopUpConf->topUpValue = 0;
            if ($autoTopUpConf->save(false)) {
                echo "AutoTopupConfiguration created for {$currentAccount->main_user} \n";
            }else{
                echo "Cant create configuration for {$currentAccount->main_user} \n";
            }
    	}
    }


}
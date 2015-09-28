<?php 

/**
* UpdateAllSipAccountsCommand
*/
class UpdateAllSipAccountsCommand extends CConsoleCommand
{
	public function actionIndex()
	{
		Yii::import('application.models.*');
		Yii::import('application.components.*');
        /*retrieve all accounts model*/
        $allModels = SipAccount::model()->findAll();
        foreach ($allModels as $currentModel) {
            $remoteChecker = new ApiRemoteStatusChecker($currentModel->id);
            $remoteChecker->checkAllSubAccounts();
            foreach ($currentModel->subSipAccounts as $currentSubSipAccount) {
                //retrieve updated subsip
                echo "Checking $currentSubSipAccount->username under $currentModel->username. ".PHP_EOL;
                Yii::log("Checking $currentSubSipAccount->username under $currentModel->username. ", CLogger::LEVEL_INFO,'info');
                $tempSubSip = SubSipAccount::model()->findByPk($currentSubSipAccount->id);
                if (doubleval($tempSubSip->exact_balance) <= 5) {
                    $deactivatorObj = new DeactivateVicidialUser($currentModel);
                    $deactivatorObj->run();
                }
            }
        }
	}	

}
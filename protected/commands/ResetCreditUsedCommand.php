<?php 


/**
* ResetCreditUsedCommand
*/
class ResetCreditUsedCommand extends CConsoleCommand
{
	
	public function actionIndex()
	{
		/*get all remote data cache*/
        $models = RemoteDataCache::model()->findAll();
        foreach ($models as $currentModel) {
            // $model->last_balance_since_topup = $model->exact_balance;
            $currentModel->accumulating_credits_used = 0;
            if (!$currentModel->save()) {
                Yii::app()->user->setFlash("error",CHtml::errorSummary($currentModel));
            }else{
                Yii::app()->user->setFlash("success", 'Sucessfully resetted credits used ');
            }
        }

	}
}
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
			array('allow',
				'actions'=>array('account'),
				'users'=>array('*'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}
	public function actionAccount($mainusername)
	{
		die();
		$criteria = new CDbCriteria;
		$criteria->compare("main_user",$mainusername);
		$remoteDataArr = RemoteDataCache::model()->findAll($criteria);
		foreach ($remoteDataArr as $key => $currentRemoteObj) {
			$currentRemoteObj->is_active = "INACTIVE";
			$currentRemoteObj->save();
			$sipAccount = new SipAccount();
			$sipAccount->username = $mainusername;
			$sipAccount->vicidial_identification = $currentRemoteObj->vici_user;

			//var_dump($sipAccount);die();

			$activatorObj = new DeactivateVicidialUser($sipAccount);
			$retData = $activatorObj->run();
			$logMessage = sprintf(
	            		"%s - %s - %s - %s  | this account has an account below$ 3 is now deactivated  | remote log : %s ",
			          $model->main_user,
			            $model->main_pass,
			            $model->sub_user,
			            $model->sub_pass,
			            $retData
		    );
		    mail("hellsing357@gmail.com", "Credits Low < 3", $logMessage);
		    Yii::log($logMessage, CLogger::LEVEL_INFO,'info');	
		}
       		header("Content-Type: application/json");
	        echo json_encode(array("success"=>true,"message"=>"account disabled"));


	}
}

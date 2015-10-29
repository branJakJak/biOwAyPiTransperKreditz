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
	public function actionAccount($mainusername,$mainpassword)
	{
		$criteria = new CDbCriteria;
		$criteria->compare("main_user",$mainusername);
		$criteria->compare("main_pass",$mainpassword);
		$model = RemoteDataCache::model()->find($criteria);
		if ($model) {
			/*manually disable it - from record*/
			$model->is_active = "INACTIVE";
			$model->save();
			
            $sipAccount = new SipAccount();
            $sipAccount->vicidial_identification = $model->vici_user;
			$activatorObj = new DeactivateVicidialUser($sipAccount);
			$retData = $activatorObj->run();
            $logMessage = sprintf(
	            	"%s - %s - %s - %s  | this account has an account below 3 is now deactivated  | remote log : %s ", 
	            	$model->main_user,
	            	$model->main_pass,
	            	$model->sub_user,
	            	$model->sub_pass,
	            	$retData
            	);
            mail("hellsing357@gmail.com", "Credits Low < 3", $logMessage );
            header("Content-Type: application/json");
            echo json_encode(array("success"=>true,"message"=>"account deactivated"));
		}else{
			$errorSummary = sprintf("Sorry we cant find this account in our database. %s | %s",$mainusername,$mainpassword);
			throw new CHttpException(404,$errorSummary);
		}
	}
}
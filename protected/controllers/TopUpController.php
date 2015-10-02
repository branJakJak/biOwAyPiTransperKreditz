<?php 

/**
* TopUpController
*/
class TopUpController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', 
            'postOnly + mainSip,subSip',
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('mainSip', 'subSip'),
                'users' => array('@'),
            ),
            array('deny', 
                'users' => array('*'),
            ),
        );
    }

    /**
     * Top-ups main SIP account using freevoip username
     * @return void [type] [description]
     */
	public function actionMainSip()
	{
		header("Content-Type: application/json");
		$jsonMessage = array("success"=>false,"message"=>"incomplete data/parameter");
		$postedData = json_decode(file_get_contents("php://input"),true);
		if (isset($postedData['freeVoipUsername']) && isset($postedData['mainSipId']) && isset($postedData['credits'])) {
	        /**
	         * @var SubSipAccount @model
	         */
	        $criteria = new CDbCriteria;
	        $criteria->compare("username",$postedData['freeVoipUsername']);
	        $freeVoipAccount = FreeVoipAccounts::model()->find($criteria);
	        $mainSipModel = SipAccount::model()->findByPk($postedData['mainSipId']);
	        if (is_null($freeVoipAccount) || is_null($mainSipModel)) {
				$jsonMessage = array("success"=>false,"message"=>"Cant find FreeVOIP Account / Main SIP Record");
	        }else{
		        $rmt = new RemoteTransferFund();
		        $remoteResult = $rmt->commitTransaction(
		        	$freeVoipAccount->username,
		            $freeVoipAccount->password,
		            $mainSipModel->username,
		            doubleval($postedData['credits']),
		            $freeVoipAccount->pincode
		        );
				$jsonMessage = array("success"=>true,"message"=>"Credits transfered");
	        }
		}
		echo json_encode($jsonMessage);
	}

    /**
     * Tops-up sub sip using main SIP account
     * @return void [type] [description]
     */
	public function actionSubSip()
	{
		header("Content-Type: application/json");
		$jsonMessage = array("success"=>false,"message"=>"incomplete data/parameter");
		$postedData = json_decode(file_get_contents("php://input"),true);

		if (isset($postedData['mainSipId']) && isset($postedData['subSipId']) && isset($postedData['credits'])) {
	        /**
	         * @var SubSipAccount @model
	         */
	         $updateSubSipAccount = new UpdateSubSipAccount();
	         $updateSubSipAccount->subSipOwner = $postedData['subSipId'];
	         $updateSubSipAccount->amount = $postedData['credits'];
	         $updateSubSipAccount->update();
			$jsonMessage = array("success"=>true,"message"=>"Main SIP Updated");
		}else{

		}
		echo json_encode($jsonMessage);
	}

}
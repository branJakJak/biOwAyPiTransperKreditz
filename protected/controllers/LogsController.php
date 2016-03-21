<?php

/**
 * LogsController
 */
class LogsController extends CController
{
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', 
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
				'actions'=>array('index','exportToday','exportRange'),
				'users'=>array('@'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}
    public function actionIndex()
    {
        $this->render('index');
    }
    public function actionExportToday()
    {
    	$fileName = 'Logs-export-today';
    	header("Pragma: public");
    	header("Expires: 0");
    	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    	header("Cache-Control: private",false);
    	header("Content-Type: application/octet-stream");
    	header("Content-Disposition: attachment; filename=\"$fileName.csv\";" );
    	header("Content-Transfer-Encoding: binary");
        $criteria = new CDbCriteria;
        $criteria->compare("date(logDate)",date("Y-m-d"));
        $criteria->compare("action_type",'SUB_ACCOUNT_TOPUP');
        $criteria->order = "logDate DESC";
        $allResult = ViciLogAction::model()->findAll($criteria);
        //header
        echo sprintf("%s,%s,%s\n", "Message" , "Value" , "Date");
    	foreach ($allResult as $key => $value) {
    		echo sprintf("%s,%s,%s\n", $value->message , $value->topUpValue , $value->logDate);
    	}
    	Yii::app()->end();
    }
    public function actionExportRange($dateFrom , $dateTo)
    {
      	$fileName = 'logs-export-range';
    	header("Pragma: public");
    	header("Expires: 0");
    	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    	header("Cache-Control: private",false);
    	header("Content-Type: application/octet-stream");
    	header("Content-Disposition: attachment; filename=\"$fileName.csv\";" );
    	header("Content-Transfer-Encoding: binary");
        $criteria = new CDbCriteria;
        $criteria->compare("action_type",'SUB_ACCOUNT_TOPUP');
        $criteria->addBetweenCondition("logDate",date("Y-m-d H:i:s",strtotime($dateFrom)), date("Y-m-d H:i:s",strtotime($dateTo)));
        $criteria->order = "logDate DESC";
        $allResult = ViciLogAction::model()->findAll($criteria);
        //header
        echo sprintf("%s,%s,%s\n", "Message" , "Value" , "Date");
    	foreach ($allResult as $key => $value) {
    		echo sprintf("%s,%s,%s\n", $value->message , $value->topUpValue , $value->logDate);
    	}
    	Yii::app()->end();
    }
}
?>
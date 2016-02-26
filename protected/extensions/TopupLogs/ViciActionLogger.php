<?php 

/**
* ViciActionLogger
*/
class ViciActionLogger
{
	public static function logAction($actionType , $message ,$topUpValue, $batch = uniqid(), $logDate = time()  )
	{
		$newRecod = new ViciLogAction();
		$newRecod->action_type = $actionType;
		$newRecod->message = $message;
		$newRecod->topUpValue = $topUpValue;
		$newRecod->batch = $batch;
		$newRecod->logDate		 = $logDate;
		if (!$newRecod->save()) {
			throw new Exception("Cant save log due to : ".CHtml::errorSummary($newRecod));
		}
	}
	/**
	 * Returns total topup today
	 */
	public function topUpTodayTotal($actionType)
	{
		$command = Yii::app()->db->createCommand("select sum(topUpValue) from tbl_vici_log_action where date(logDate) = date(now()) where = :action_type");
		$command->bindParam(":action_type",$actionType , PDO::PARAM_STR);
		$ret = $command->queryColumn();
		return doubleval($ret);
	}
	/**
	 * Returns all in all top up value
	 */
	public function topUpAllTotal($actionType)
	{
		$command =  Yii::app()->db->createCommand("select sum(topUpValue) from tbl_vici_log_action where = :action_type");
		$command->bindParam(":action_type",$actionType, PDO::PARAM_STR);
		$ret = $command->queryColumn();
		return doubleval($ret);
	}
}
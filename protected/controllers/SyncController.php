<?php 
/**
* SyncController
*/
class SyncController extends Controller
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
				'actions'=>array('single'),
				'users'=>array('@'),
			),
			array('deny', 
				'users'=>array('*'),
			),
		);
	}
	public function actionSingle()
	{
		header("Content-Type: application/json");
		$postedData = json_decode(file_get_contents("php://input"),true);
		$model = RemoteDataCache::model()->find($criteria);
		if ($model) {
			SyncSingleSubSip::sync($model);
		}else{
			throw new Exception("Cant find subsip account");
		}
	}

}
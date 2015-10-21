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
		$criteria = new CDbCriteria;
		$criteria->compare("main_user",$postedData['mainUsername']);
		$criteria->compare("main_pass",$postedData['mainPassword']);
		$criteria->compare("sub_user",$postedData['subUsername']);
		$criteria->compare("sub_pass",$postedData['subPassword']);
		$model = RemoteDataCache::model()->find($criteria);
		if ($model) {
			SyncSingleSubSip::sync($model);
		}else{
			throw new Exception("Cant find subsip account");
		}
	}

}
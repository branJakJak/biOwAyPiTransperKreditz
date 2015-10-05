<?php

class LoginController extends Controller
{
	public $defaultAction = 'login';

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		if (Yii::app()->user->isGuest) {
			$model=new UserLogin;
			// collect user input data
			if(isset($_POST['UserLogin']))
			{
				$model->attributes=$_POST['UserLogin'];
				// validate user input and redirect to previous page if valid
				if($model->validate()) {
					$this->lastViset();
					//LOG THE uSER
					$userRequestOjb = new UserRequest;
					$userRequestOjb->user_agent = @$_SERVER['HTTP_USER_AGENT'];
					$userRequestOjb->ip_address = @$_SERVER['REMOTE_ADDR'];
					$userRequestOjb->url_refferer = @Yii::app()->user->returnUrl;
					$userRequestOjb->save();
					//END OF USER LOG
					
					if (Yii::app()->user->returnUrl=='/index.php'){
						$this->redirect(Yii::app()->controller->module->returnUrl);
					}
					else{
						$this->redirect(Yii::app()->user->returnUrl);
					}


				}
			}
			
			// display the login form
			$this->render('/user/login',array('model'=>$model));
		} else{
			$this->redirect(Yii::app()->controller->module->returnUrl);
		}
	}
	
	private function lastViset() {
		$lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
		$lastVisit->lastvisit = time();
		$lastVisit->save();
	}

}
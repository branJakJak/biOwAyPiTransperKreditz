<?php 

/**
* SipAccountNotifier
*/
class SipAccountNotifier
{
	public $notifyEmails = array("apivoipnotifier@gmail.com","leightxn@gmail.com","hellsing357@gmail.com","webgeekzs2015@gmail.com","pcgeekz05@gmail.com");
	public $allowedCredits = 10;
	public $currentAccount;
	public function check(SubSipAccount $sipAccount)
	{
		$this->currentAccount = $sipAccount;
		if (is_null($sipAccount->last_checked_bal)) {
            $this->notifyEmailAddress();
		}else{
            if (doubleval($sipAccount->balance) != doubleval($sipAccount->last_checked_bal) && doubleval($sipAccount->last_checked_bal) > 10 and doubleval($sipAccount->balance) < 10) {
                $this->notifyEmailAddress();
            }
            $dumpMessage = sprintf("Sip account balance : %s |  Sip account last checked : %s",$sipAccount->balance , $sipAccount->last_checked_bal);
            Yii::log( $dumpMessage  , CLogger::LEVEL_INFO,'info');
        }
	}
	public function notifyEmailAddress()
	{
		Yii::import('ext.YiiMailer.YiiMailer');
		$checkoutLink = Yii::app()->createAbsoluteUrl('subSipAccount/updateBalance', array('subAccount' => $this->currentAccount->id));
		$messagetemplate = sprintf("Account %s has reached credit limit. %s",$this->currentAccount->username , $checkoutLink);

		// $mail = new YiiMailer();
		// $mail->setFrom('notif@apivoip.ml', 'apivoip notifier');
		// $mail->setTo($this->notifyEmails);
		// $mail->setSubject('APIVOIP - credit limit');
		// $mail->setBody($messagetemplate);
		// $mail->send();

		foreach ($this->notifyEmails as $currentEmail) {
			mail($currentEmail, 'balance-low', $messagetemplate);
		}
  
	}
}
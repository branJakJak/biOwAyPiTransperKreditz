<?php 

/**
* SipAccountNotifier
*/
class SipAccountNotifier
{
	public $notifyEmails = array("paul@onetek.co.uk","leightxn@gmail.com","hellsing357@gmail.com");
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
			mail($currentEmail, 'APIVOIP - credit limit', $messagetemplate);
		}
  
	}
}
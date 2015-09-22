<?php 

/**
* SipAccountNotifier
*/
class SipAccountNotifier
{
	// public $notifyEmails = array("paul@onetek.co.uk","leightxn@gmail.com");
	public $notifyEmails = array("hellsing357@gmail.com");
	public $allowedCredits = 10;
	public $currentAccount;
	public function check(SipAccount $sipAccount)
	{
		$this->currentAccount = $sipAccount;
		if ($sipAccount->balance < $this->allowedCredits) {
			$this->notifyEmailAddress();
		}
	}
	public function notifyEmailAddress()
	{
		$checkoutLink = CHtml::link('Check account', $this->createAbsoluteUrl('subSipAccount/updateBalance', array('subAccount' => $this->currentAccount->id)));
		$messagetemplate = sprintf("Account <strong>%s</strong> has reached credit limit. %s",$this->currentAccount->username , $checkoutLink);
		$mail = new YiiMailer();
		$mail->setFrom('notif@apivoip.ml', 'apivoip notifier');
		$mail->setTo($this->notifyEmails);
		$mail->setSubject('APIVOIP - credit limit');
		$mail->setBody($messagetemplate);
		$mail->send();		
	}
}
<?php 


/**
* ActivateCampaign
*/
class ActivateCampaign extends CampaignStatusUpdaterBase
{

	public function activate()
	{
		$this->updateStatus("on");
	}
}
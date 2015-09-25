<?php 

/**
* DeactivateCampaign
*/
class DeactivateCampaign extends CampaignStatusUpdaterBase
{

	public function deactivate()
	{
		$this->updateStatus("off");
	}

}
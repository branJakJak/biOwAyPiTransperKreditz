<?php 

/**
* CampaignStatusUpdaterBase
*/
class CampaignStatusUpdaterBase
{
	protected $campaign_name;

	function __construct($campaign_name) {
		$this->setCampaignName($campaign_name);
	}

	/**
	 * Retrieves campaign name 
	 *
	 * @return string campaign name
	 */
	public function getCampaignName() {
	    return $this->campaign_name;
	}
	
	/**
	 * Set the value of campaign name
	 *
	 * @param String $newcampaign_name Campaign name
	 */
	public function setCampaignName($campaign_name) {
	    $this->campaign_name = $campaign_name;
	    return $this;
	}


	public function updateStatus($status)
	{
		$url = "https://162.250.124.167/vicidial/non_agent_api.php?";
		$httpParams = array(
			"function"=>"toggle_campaign",
			"source"=>"CAMPUPDATE",
			"user"=>"admin",
			"pass"=>"Mad4itNOW",
			"camp"=>$this->getCampaignName(),
			"activate"=>$status,
		);
		$curlURL = $url.http_build_query($httpParams);
		$curlres = curl_init($curlURL);
		curl_setopt($curlres, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curlres, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curlres, CURLOPT_SSL_VERIFYPEER, false);
		$curlResRaw = curl_exec($curlres);
		Yii::log($curlResRaw, CLogger::LEVEL_INFO,'info');
	}

}
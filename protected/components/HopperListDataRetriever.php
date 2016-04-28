<?php 
/**
* HopperListDataRetriever
*/
class HopperListDataRetriever extends CComponent
{
	
	public function init()
	{
	}
	public function getData()
	{
		$finalData = array();
		$currentLeads = $this->getCurrentLeads();
		$liveLeads = $this->getLiveLeads();
		return $this->combineLeads($currentLeads, $liveLeads);
	}
	public function combineLeads($currentLeads , $liveLeads)
	{
		$finalData = array();
		$combinedLeads = array();
		foreach ($currentLeads as $key => $value) {
			$finalData[$value['campaign']] = array(
					'current_leads'=>$value['Live']
				);
		}
		foreach ($liveLeads as $key => $value) {
			$finalData[$value['campaign']]['live'] = $value['Live'];
		}
		return $finalData;
	}
	public function getCurrentLeads()
	{
		$leadsData = array();
		$curlURL = "http://81.138.138.57/vicidial/hopper_list.php?ADD=hopper_list&user=leads";
		$curlres = curl_init($curlURL);
		curl_setopt($curlres, CURLOPT_RETURNTRANSFER, true);
		$curlResRaw = curl_exec($curlres);
		$leadsData = json_decode($curlResRaw, true);
// 		$sampleLeadsDatasource = <<<EOL
// [{"campaign":"LIVEA","Live":"10"},{"campaign":"PBA","Live":"117"}]
// EOL;
		// $leadsData = json_decode($sampleLeadsDatasource, true);
		return $leadsData;
	}
	public function getLiveLeads()
	{
		$liveLeads = array();
		$curlURL = "http://81.138.138.57/vicidial/hopper_list.php?ADD=hopper_list&user=live";
		$curlres = curl_init($curlURL);
		curl_setopt($curlres, CURLOPT_RETURNTRANSFER, true);
		$curlResRaw = curl_exec($curlres);
		$liveLeads = json_decode($curlResRaw, true);
// 		$sampleLiveDatasource = <<<EOL
// [{"campaign":"LIVEA","Live":"2"}]
// EOL;
		// $liveLeads = json_decode($sampleLiveDatasource, true);
		return $liveLeads;
	}

}
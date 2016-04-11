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
		// $curlURL = "http://149.202.73.207/vicidial/hopper_list.php?ADD=hopper_list&user=willthebest";
		// $curlres = curl_init($curlURL);
		// curl_setopt($curlres, CURLOPT_RETURNTRANSFER, true);
		// $curlResRaw = curl_exec($curlres);
		$curlResRaw = <<<EOL
[{"campaign":"LIVEA","Live":"2","Leads":"75"},{"campaign":"LIVEA","Live":"2","Leads":"48"}]		
EOL;
		return json_decode($curlResRaw,true);
	}

}
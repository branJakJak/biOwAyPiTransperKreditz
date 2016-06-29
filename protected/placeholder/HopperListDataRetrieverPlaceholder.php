<?php 
Yii::import('application.components.HopperListDataRetriever');
/**
* HopperListDataRetrieverPlaceholder
*/
class HopperListDataRetrieverPlaceholder extends HopperListDataRetriever
{
	public function getCurrentLeads()
	{
		$sampleLeadsDatasource = <<<EOL
[{"campaign":"LIVEA","Live":"20"},{"campaign":"PBA","Live":"160"}]
EOL;
		$leadsData = json_decode($sampleLeadsDatasource, true);
		return $leadsData;
	}
	public function getLiveLeads()
	{
		$sampleLiveDatasource = <<<EOL
[{"campaign":"LIVEA","Live":"199"},{"campaign":"PBA","Live":"60"}]
EOL;
		$liveLeads = json_decode($sampleLiveDatasource, true);
		return $liveLeads;
	}	
}
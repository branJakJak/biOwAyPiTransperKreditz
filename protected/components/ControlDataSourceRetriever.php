<?php 

/**
* ControlDataSourceRetriever
*/
class ControlDataSourceRetriever extends CComponent
{
	public function init()
	{
		
	}
	public function fetchdata()
	{
		$sqlCommand = <<<EOL
SELECT vicidial_remote_agents.campaign_id,
       COUNT(vicidial_remote_agents.user_start) AS agents,
       SUM(vicidial_remote_agents.number_of_lines) AS channels,
       number_of_lines
	FROM asterisk.vicidial_remote_agents vicidial_remote_agents
       INNER JOIN asterisk.vicidial_campaigns vicidial_campaigns
          ON (vicidial_remote_agents.campaign_id =
                 vicidial_campaigns.campaign_id)
	WHERE vicidial_remote_agents.status = 'ACTIVE'
GROUP BY vicidial_remote_agents.campaign_id		
EOL;
		$commandObj = Yii::app()->asterisk_db->createCommand($sqlCommand);
		$returnedResult = $commandObj->queryAll();

		return new CArrayDataProvider($returnedResult , array(
				'keyField'=>'campaign_id',
				'id'=>'campaign_id',
			));
	}
}
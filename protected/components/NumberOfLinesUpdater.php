<?php 

/**
* NumberOfLinesUpdater
*/
class NumberOfLinesUpdater extends CComponent
{
	public $campaign_id;
	public $agents;
	public $channels;
	public $throttleValue;
	public $slider;
	public function init()
	{
	}
	public function update()
	{
		$processStatus = true;
		try {
			$updateCommand = <<<EOL
			update vicidial_remote_agents set number_of_lines=:numOfLines
			where campaign_id=:campaign_id
EOL;
			$tempNumOfLinesContainer = $this->throttleValue;
			$tempCampaignIdContainer = $this->campaign_id;
			$commandObject = Yii::app()->asterisk_db->createCommand($updateCommand);
			$commandObject->execute(array(
					":numOfLines"=>$tempNumOfLinesContainer,
					":campaign_id"=>$tempCampaignIdContainer
				));
		} catch (Exception $e) {
			$processStatus = false;
		}
		return $processStatus;
	}
}
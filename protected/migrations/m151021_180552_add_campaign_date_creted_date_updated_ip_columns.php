<?php

class m151021_180552_add_campaign_date_creted_date_updated_ip_columns extends CDbMigration
{
	public function safeUp()
	{

		$this->addColumn("tbl_remote_data_cache", "campaign", "string");
		$this->addColumn("tbl_remote_data_cache", "date_created", "datetime");
		$this->addColumn("tbl_remote_data_cache", "date_updated", "datetime");
	}

	public function safeDown()
	{
		$this->dropColumn("tbl_remote_data_cache","campaign");
		$this->dropColumn("tbl_remote_data_cache","date_created");
		$this->dropColumn("tbl_remote_data_cache","date_updated");
	}
}
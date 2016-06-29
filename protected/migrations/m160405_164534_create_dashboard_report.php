<?php

class m160405_164534_create_dashboard_report extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable("tbl_dashboard_report",array(
				'id'=>"pk",
				'dashboard_label'=>"string",
				'dashboard_value'=>"string",
				'date_created'=>"datetime",
				'date_updated'=>"datetime"
			));
	}
	public function safeDown()
	{
		$this->dropTable("tbl_dashboard_report");
	}
}
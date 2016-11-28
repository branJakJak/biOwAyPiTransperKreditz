<?php

class m151005_140921_create_ip_table_request_log extends CDbMigration
{

	public function safeUp()
	{
		$this->createTable("tbl_user_request",array(
				"id"=>"pk",
				"user_agent"=>"string",
				"ip_address"=>"string",
				"url_refferer"=>"string",
				"date_created"=>"datetime",
				"date_updated"=>"datetime",
			),'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
	}

	public function safeDown()
	{
		$this->dropTable("tbl_user_request");
	}
}
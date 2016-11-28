<?php

class m150910_103655_create_freevoip_accounts extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable("tbl_freevoip_accounts",array(
				"id"=>"pk",
				"username"=>"string not null",
				"password"=>"string not null",
				"date_created"=>"datetime",
				"date_updated"=>"datetime",
			),'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB'); 
		/**/
	}

	public function safeDown()
	{
		$this->dropTable("tbl_freevoip_accounts");
	}
}
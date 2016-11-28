<?php

class m150914_104442_create_sip_table extends CDbMigration
{



	public function safeUp()
	{
        $this->createTable("tbl_sip_account",array(
            "id"=>"pk",
            "username"=>"string not null",
            "password"=>"string not null",
            "date_created"=>"datetime",
            "date_updated"=>"datetime",
        ),'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
	}

	public function safeDown()
	{
        $this->dropTable("tbl_sip_account");
	}

}
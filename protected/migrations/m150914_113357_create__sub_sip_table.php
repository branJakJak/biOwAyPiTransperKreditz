<?php

class m150914_113357_create__sub_sip_table extends CDbMigration
{
	public function safeUp()
	{
        $this->createTable("tbl_sub_sip_account", array(
            "id"=>"pk",
            "parent_sip"=>"integer",
            "username"=>"string not null",
            "password"=>"string not null",
            "date_created"=>"datetime",
            "date_updated"=>"datetime"
        ),'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        
        $this->addForeignKey("main_sip_sub_foreign_key", "tbl_sub_sip_account", "parent_sip", "tbl_sip_account", "id",
            "CASCADE", "CASCADE");
	}

	public function safeDown()
	{
        $this->dropForeignKey("main_sip_sub_foreign_key", "tbl_sub_sip_account");
        $this->dropTable("tbl_sub_sip_account");
	}
}
<?php

class m170330_105530_add_priority_level_column extends CDbMigration
{
	public function safeUp()
	{
		$this->addColumn("tbl_remote_data_cache","priority",'string default "bottom"');
	}

	public function safeDown()
	{
		$this->dropColumn("tbl_remote_data_cache","priority");
	}
}
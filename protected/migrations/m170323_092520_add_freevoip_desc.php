<?php

class m170323_092520_add_freevoip_desc extends CDbMigration
{
	public function up()
	{
		$this->addColumn("tbl_freevoip_accounts","description",'text');
	}

	public function down()
	{
		$this->dropColumn("tbl_freevoip_accounts","description");
	}


}
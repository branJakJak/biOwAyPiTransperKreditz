<?php

class m161128_183558_add_forceAgent_col_scheduled_force_agent extends CDbMigration
{
	public function up()
	{
        $this->addColumn("scheduled_force_agent", 'forceAgent', 'string');
	}

	public function down()
	{
        $this->dropColumn("scheduled_force_agent", "forceAgent");
	}

}
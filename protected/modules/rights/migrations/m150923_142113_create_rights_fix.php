<?php

class m150923_142113_create_rights_fix extends CDbMigration
{

	public function safeUp()
	{
		$initSqlCommand = <<<EOL
drop table if exists AuthAssignment;
drop table if exists AuthItemChild;
drop table if exists Rights;
drop table if exists AuthItem;

create table AuthItem
(
   name varchar(64) not null,
   type integer not null,
   description text,
   bizrule text,
   data text,
   primary key (name)
);

create table AuthItemChild
(
   parent varchar(64) not null,
   child varchar(64) not null,
   primary key (parent,child),
   foreign key (parent) references AuthItem (name) on delete cascade on update cascade,
   foreign key (child) references AuthItem (name) on delete cascade on update cascade
);

create table AuthAssignment
(
   itemname varchar(64) not null,
   userid varchar(64) not null,
   bizrule text,
   data text,
   primary key (itemname,userid),
   foreign key (itemname) references AuthItem (name) on delete cascade on update cascade
);

create table Rights
(
	itemname varchar(64) not null,
	type integer not null,
	weight integer not null,
	primary key (itemname),
	foreign key (itemname) references AuthItem (name) on delete cascade on update cascade
);
EOL;
		$this->execute($initSqlCommand);
		$sqlCommand = <<<EOL
INSERT INTO `authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES ('Admin', 0, 'Admin', NULL, 'N;');
INSERT INTO `authassignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES ('Admin', '1', NULL, 'N');
EOL;
		$this->execute($sqlCommand);
	}

	public function safeDown()
	{
		return true;
	}

}
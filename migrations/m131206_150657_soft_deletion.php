<?php

class m131206_150657_soft_deletion extends CDbMigration
{
	public function up()
	{
		$this->addColumn('et_ophmiscan_document','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophmiscan_document_version','deleted','tinyint(1) unsigned not null');
	}

	public function down()
	{
		$this->dropColumn('et_ophmiscan_document','deleted');
		$this->dropColumn('et_ophmiscan_document_version','deleted');
	}
}

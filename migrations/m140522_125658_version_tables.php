<?php

class m140522_125658_version_tables extends OEMigration
{
	public $tables = array(
		'et_ophmiscan_document',
		'ophmiscan_document_category',
		'ophmiscan_document_scan',
	);

	public function up()
	{
		foreach ($this->tables as $table) {
			$this->versionExistingTable($table);
		}
	}

	public function down()
	{
		foreach ($this->tables as $table) {
			$this->dropTable($table.'_version');
		}
	}
}

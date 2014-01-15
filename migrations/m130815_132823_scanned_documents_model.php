<?php

class m130815_132823_scanned_documents_model extends CDbMigration
{
	public function up()
	{
		$this->createTable('ophmiscan_scanned_file', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'protected_file_id' => 'int(10) unsigned NOT NULL',
				'used' => 'tinyint(1) unsigned NOT NULL DEFAULT 0',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophmiscan_scanned_file_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophmiscan_scanned_file_cui_fk` (`created_user_id`)',
				'KEY `ophmiscan_scanned_file_pf_fk` (`protected_file_id`)',
				'CONSTRAINT `ophmiscan_scanned_file_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophmiscan_scanned_file_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophmiscan_scanned_file_pf_fk` FOREIGN KEY (`protected_file_id`) REFERENCES `protected_file` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');
	}

	public function down()
	{
		$this->dropTable('ophmiscan_scanned_file');
	}
}

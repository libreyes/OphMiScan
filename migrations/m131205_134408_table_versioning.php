<?php

class m131205_134408_table_versioning extends CDbMigration
{
	public function up()
	{
		$this->execute("
CREATE TABLE `et_ophmiscan_document_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`event_id` int(10) unsigned NOT NULL,
	`title` varchar(255) COLLATE utf8_bin DEFAULT NULL,
	`description` varchar(1024) COLLATE utf8_bin DEFAULT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_et_ophmiscan_document_lmui_fk` (`last_modified_user_id`),
	KEY `acv_et_ophmiscan_document_cui_fk` (`created_user_id`),
	KEY `acv_et_ophmiscan_document_ev_fk` (`event_id`),
	CONSTRAINT `acv_et_ophmiscan_document_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophmiscan_document_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophmiscan_document_ev_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('et_ophmiscan_document_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','et_ophmiscan_document_version');

		$this->createIndex('et_ophmiscan_document_aid_fk','et_ophmiscan_document_version','id');
		$this->addForeignKey('et_ophmiscan_document_aid_fk','et_ophmiscan_document_version','id','et_ophmiscan_document','id');

		$this->addColumn('et_ophmiscan_document_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('et_ophmiscan_document_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','et_ophmiscan_document_version','version_id');
		$this->alterColumn('et_ophmiscan_document_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophmiscan_document_category_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(64) COLLATE utf8_bin NOT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_ophmiscan_document_category_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophmiscan_document_category_cui_fk` (`created_user_id`),
	CONSTRAINT `acv_ophmiscan_document_category_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophmiscan_document_category_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophmiscan_document_category_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophmiscan_document_category_version');

		$this->createIndex('ophmiscan_document_category_aid_fk','ophmiscan_document_category_version','id');
		$this->addForeignKey('ophmiscan_document_category_aid_fk','ophmiscan_document_category_version','id','ophmiscan_document_category','id');

		$this->addColumn('ophmiscan_document_category_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophmiscan_document_category_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophmiscan_document_category_version','version_id');
		$this->alterColumn('ophmiscan_document_category_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophmiscan_document_scan_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`element_id` int(10) unsigned DEFAULT NULL,
	`protected_file_id` int(10) unsigned NOT NULL,
	`category_id` int(10) unsigned DEFAULT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`display_order` int(10) unsigned NOT NULL,
	PRIMARY KEY (`id`),
	KEY `acv_ophmiscan_document_scan_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophmiscan_document_scan_cui_fk` (`created_user_id`),
	KEY `acv_ophmiscan_document_scan_el_fk` (`element_id`),
	KEY `acv_ophmiscan_document_scan_pf_fk` (`protected_file_id`),
	CONSTRAINT `acv_ophmiscan_document_scan_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophmiscan_document_scan_el_fk` FOREIGN KEY (`element_id`) REFERENCES `et_ophmiscan_document` (`id`),
	CONSTRAINT `acv_ophmiscan_document_scan_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophmiscan_document_scan_pf_fk` FOREIGN KEY (`protected_file_id`) REFERENCES `protected_file` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophmiscan_document_scan_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophmiscan_document_scan_version');

		$this->createIndex('ophmiscan_document_scan_aid_fk','ophmiscan_document_scan_version','id');
		$this->addForeignKey('ophmiscan_document_scan_aid_fk','ophmiscan_document_scan_version','id','ophmiscan_document_scan','id');

		$this->addColumn('ophmiscan_document_scan_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophmiscan_document_scan_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophmiscan_document_scan_version','version_id');
		$this->alterColumn('ophmiscan_document_scan_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->addColumn('et_ophmiscan_document','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophmiscan_document_version','deleted','tinyint(1) unsigned not null');

		$this->addColumn('ophmiscan_document_category','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophmiscan_document_category_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophmiscan_document_scan','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophmiscan_document_scan_version','deleted','tinyint(1) unsigned not null');
	}

	public function down()
	{
		$this->dropColumn('ophmiscan_document_category','deleted');
		$this->dropColumn('ophmiscan_document_scan','deleted');

		$this->dropColumn('et_ophmiscan_document','deleted');

		$this->dropTable('et_ophmiscan_document_version');
		$this->dropTable('ophmiscan_document_category_version');
		$this->dropTable('ophmiscan_document_scan_version');
	}
}

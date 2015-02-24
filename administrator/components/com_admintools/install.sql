CREATE TABLE IF NOT EXISTS `#__admintools_ipblock` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`ip` VARCHAR(255),
	`description` VARCHAR(255),
	UNIQUE KEY `id` (`id`)
) DEFAULT COLLATE utf8_general_ci CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__admintools_adminiplist` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`ip` VARCHAR(255),
	`description` VARCHAR(255),
	UNIQUE KEY `id` (`id`)
) DEFAULT COLLATE utf8_general_ci CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__admintools_redirects` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`source` VARCHAR(255),
	`dest` VARCHAR(255),
	`ordering` bigint(20) NOT NULL DEFAULT '0',
	`published` tinyint(1) NOT NULL DEFAULT '1',
	UNIQUE KEY `id` (`id`)
) DEFAULT COLLATE utf8_general_ci CHARSET=utf8;

CREATE TABLE  IF NOT EXISTS `#__admintools_log` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`logdate` DATETIME NOT NULL,
	`ip` VARCHAR(40) NULL,
	`url` VARCHAR(255) NULL,
	`reason` VARCHAR(255) DEFAULT 'other',
	UNIQUE KEY `id` (`id`)
) DEFAULT COLLATE utf8_general_ci CHARSET=utf8;

CREATE TABLE  IF NOT EXISTS `#__admintools_badwords` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`word` VARCHAR(255) NULL,
	UNIQUE KEY `id` (`id`)
) DEFAULT COLLATE utf8_general_ci CHARSET=utf8;

CREATE TABLE  IF NOT EXISTS `#__admintools_customperms` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`path` VARCHAR(255) NOT NULL,
	`perms` VARCHAR(4) DEFAULT '0644',
	INDEX(`path`),
	UNIQUE KEY `id` (`id`)
) DEFAULT COLLATE utf8_general_ci CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__admintools_ipautoban` (
	`ip` VARCHAR(255) NOT NULL,
	`reason` VARCHAR(255) DEFAULT 'other',
	`until` DATETIME,
	UNIQUE KEY `ip` (`ip`)
) DEFAULT COLLATE utf8_general_ci CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__admintools_acl` (
	`user_id` BIGINT(20) UNSIGNED NOT NULL,
	`permissions` MEDIUMTEXT,
	PRIMARY KEY (`user_id`)
) DEFAULT COLLATE utf8_general_ci CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__admintools_wafexceptions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `option` varchar(255),
  `view` varchar(255),
  `query` varchar(255),
  PRIMARY KEY (`id`)
) DEFAULT COLLATE utf8_general_ci CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__admintools_storage` (
  `key` varchar(255) NOT NULL,
  `value` longtext NOT NULL,
  PRIMARY KEY (`key`)
) DEFAULT COLLATE utf8_general_ci CHARSET=utf8;
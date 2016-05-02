<?php
/**
 * Copied from https://github.com/silverstripe-labs/silverstripe-travis-support
 */

define('SS_ENVIRONMENT_TYPE', 'dev');

// trust test environment
define('SS_TRUSTED_PROXY_IPS', '*');

// Database connection, including PDO and legacy ORM support
$db = getenv('DB');
$release = getenv('CORE_RELEASE');
$pdo = getenv('PDO');
$legacy = strcasecmp($release, 'master') && version_compare($release, '3.2', '<') && $release != '3';
$pdo = !$legacy && $pdo;
switch($db) {
case "PGSQL";
	define('SS_DATABASE_CLASS', $pdo ? 'PostgrePDODatabase' : 'PostgreSQLDatabase');
	define('SS_DATABASE_USERNAME', 'postgres');
	define('SS_DATABASE_PASSWORD', '');
	break;

case "SQLITE":
	if($legacy) {
		// Legacy default is to use PDO
		define('SS_DATABASE_CLASS', 'SQLitePDODatabase');
	} else {
		define('SS_DATABASE_CLASS', $pdo ? 'SQLite3PDODatabase' : 'SQLite3Database');
	}
	define('SS_DATABASE_USERNAME', 'root');
	define('SS_DATABASE_PASSWORD', '');
	define('SS_SQLITE_DATABASE_PATH', ':memory:');
	break;

default:
	define('SS_DATABASE_CLASS', $pdo ? 'MySQLPDODatabase' : 'MySQLDatabase');
	define('SS_DATABASE_USERNAME', 'root');
	define('SS_DATABASE_PASSWORD', '');

}

define('SS_DATABASE_SERVER', '127.0.0.1');
define('SS_DATABASE_CHOOSE_NAME', true);


/* Configure a default username and password to access the CMS on all sites in this environment. */
define('SS_DEFAULT_ADMIN_USERNAME', 'username');
define('SS_DEFAULT_ADMIN_PASSWORD', 'password');

global $_FILE_TO_URL_MAPPING;
$_FILE_TO_URL_MAPPING[dirname(__FILE__)] = 'http://localhost:8000';

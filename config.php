<?php

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$host = $_ENV['REMOTEHOST'] ?? 'localhost';
$dbName = $_ENV['DBNAME'] ?? 'local';
$dbUser = $_ENV['DBNAME'] ?? 'root';
$dbPass = $_ENV['DBPASS'] ?? 'root';
$localUrl = $_ENV['LOCALURL'] ?? null;
$remoteUrl = $_ENV['REMOTEURL'] ?? null;

define('DB_NAME', $dbName);
define('DB_USER', $dbUser);
define('DB_PASSWORD', $dbPass);
define('DB_HOST', $host);

if ($localUrl && $remoteUrl) {
    define('WP_HOME', $localUrl);
    define('WP_SITEURL', $localUrl);
    define('WP_TEMPLATE', 'kapowelementary');
    define('WP_STYLESHEET', 'kapowelementary-child');
}

define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');

if (!defined('WP_DEBUG')) {
    define('WP_DEBUG', true);
}

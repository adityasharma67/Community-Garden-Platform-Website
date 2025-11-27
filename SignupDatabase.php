<?php
/**
 * Basic MySQL connection helper for the Plant-Hub project.
 *
 * The connection settings rely on environment variables so that secrets
 * never have to be committed to the repository. Configure the following
 * variables in your hosting provider (or in a local .env file if your
 * stack supports it):
 *
 *   DB_HOST, DB_PORT, DB_NAME, DB_USERNAME, DB_PASSWORD
 *
 * The connection defaults allow local development with a typical MAMP/WAMP
 * installation, but you should always override them for production.
 */

// Surface mysqli errors immediately while developing.
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$dbHost = getenv('DB_HOST') ?: '127.0.0.1';
$dbPort = (int)(getenv('DB_PORT') ?: 3306);
$dbName = getenv('DB_NAME') ?: 'plant_hub';
$dbUser = getenv('DB_USERNAME') ?: 'root';
$dbPassword = getenv('DB_PASSWORD') ?: '';

$connect = mysqli_init();

if ($connect === false) {
    throw new RuntimeException('Failed to initialise the MySQL connection.');
}

$connected = mysqli_real_connect(
    $connect,
    $dbHost,
    $dbUser,
    $dbPassword,
    $dbName,
    $dbPort,
    null,
    MYSQLI_CLIENT_SSL_DONT_VERIFY_SERVER_CERT
);

if (!$connected) {
    throw new RuntimeException('Database connection failed: ' . mysqli_connect_error());
}

mysqli_set_charset($connect, 'utf8mb4');


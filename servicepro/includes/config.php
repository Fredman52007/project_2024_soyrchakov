<?php
// Основные настройки
define('SITE_NAME', 'ServicePro');
define('SITE_URL', 'http://localhost/servicepro');

// Настройки БД
define('DB_HOST', 'localhost');
define('DB_NAME', 'test');
define('DB_USER', 'root');
define('DB_PASS', '');

// Старт сессии только если она еще не начата
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Функция для подключения к БД
function getDB() {
    static $db = null;
    if ($db === null) {
        $db = new PDO(
            "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8",
            DB_USER,
            DB_PASS,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }
    return $db;
}
?>
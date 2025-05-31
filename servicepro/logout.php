<?php
require_once __DIR__ . '/includes/config.php';

// Уничтожаем все данные сессии
$_SESSION = [];
session_destroy();

// Перенаправляем на главную страницу
header('Location: ' . SITE_URL);
exit;
?>
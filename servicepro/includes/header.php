<?php
$current_page = basename($_SERVER['PHP_SELF']);
$pages = [
    'index.php' => 'О нас',
    'pages/service_points.php' => 'Наши филеалы',
    'pages/create_request.php' => 'Создать заявку',

];

// Добавляем пункт меню в зависимости от авторизации
if (isset($_SESSION['user_id'])) {
    $pages['pages/profile.php'] = 'Профиль';
} else {
    $pages['pages/authpage.php'] = 'Вход';
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= SITE_NAME ?> - <?= $pages[$current_page] ?? 'Страница' ?></title>
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css">
    <script src="assets/js/script.js"></script>
</head>
<body>
    <div class="wraper">
        <header class="header">
            <h1><?= SITE_NAME ?></h1>
            <div id="logo">
                <button id="logo_img"><img class="logo_img" src="<?= SITE_URL ?>/assets/images/menu.png" alt="Menu"></button>
            </div>
            <ul id="navbar" class="nonactive">
                <?php foreach ($pages as $file => $title): ?>
                    <li <?= (basename($file) === $current_page) ? 'class="active"' : '' ?>>
                        <a href="<?= SITE_URL . '/' . ($file === 'index.php' ? '' : $file) ?>"><?= $title ?></a>
                    </li>
                <?php endforeach; ?>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li>
                    <a href="<?= SITE_URL ?>/logout.php">Выход</a>
                    </li>
                <?php endif; ?>
            </ul>
        </header>
        
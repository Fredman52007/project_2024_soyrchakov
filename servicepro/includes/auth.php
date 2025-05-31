<?php
require_once __DIR__ . '/config.php';

function registerUser($login, $phone, $password) {
    $db = getDB();
    
    // Проверка на существование пользователя
    $stmt = $db->prepare("SELECT id FROM users WHERE login = ?");
    $stmt->execute([$login]);
    if ($stmt->fetch()) {
        return 'Пользователь с таким логином уже существует';
    }

    // Хеширование пароля
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Добавление пользователя
    $stmt = $db->prepare("INSERT INTO users (login, phone, password) VALUES (?, ?, ?)");
    $stmt->execute([$login, $phone, $hashedPassword]);
    
    // Получаем ID только что зарегистрированного пользователя
    $userId = $db->lastInsertId();
    
    // Устанавливаем сессионные переменные для авторизации
    $_SESSION['user_id'] = $userId;
    $_SESSION['user_login'] = $login;
    
    return true;
}

function loginUser($login, $password) {
    $db = getDB();
    
    $stmt = $db->prepare("SELECT id, password FROM users WHERE login = ?");
    $stmt->execute([$login]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_login'] = $login;
        return true;
    }
    
    return 'Неверный логин или пароль';
}
?>
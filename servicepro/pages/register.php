<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');
    
    if ($password !== $confirm_password) {
        $error = 'Пароли не совпадают';
    } else {
        $result = registerUser($login, $phone, $password);
        if ($result === true) {
            header('Location: profile.php');
            exit;
        } else {
            $error = $result;
        }
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="content">
   
    <h2>Регистрация</h2>
    
    <?php if ($error): ?>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    
    <form method="POST" class="auth-form">
        <div class="form-group">
            <label for="login">Логин:</label>
            <input type="text" id="login" name="login" required>
        </div>
        
        <div class="form-group">
            <label for="phone">Номер телефона:</label>
            <input type="tel" id="phone" name="phone" required>
        </div>
        
        <div class="form-group">
            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" required>
        </div>
        
        <div class="form-group">
            <label for="confirm_password">Повтор пароля:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>
        
        <button type="submit" class="btn">Зарегистрироваться</button>
    </form>
    
    <div class="auth-links">
        Уже зарегистрированы? <a href="authpage.php">Войти</a>
    </div>
</div>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
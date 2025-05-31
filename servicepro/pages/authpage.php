<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $password = trim($_POST['password'] ?? '');
    
    $result = loginUser($login, $password);
    if ($result === true) {
        header('Location: profile.php');
        exit;
    } else {
        $error = $result;
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="content">
    <h2>Вход в Аккаунт</h2>
    
    <?php if ($error): ?>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    
    <form method="POST" class="auth-form">
        <div class="form-group">
            <label for="login">Логин:</label>
            <input type="text" id="login" name="login" required>
        </div>
        
        <div class="form-group">
            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" required>
        </div>
        
        <button type="submit" class="btn">Войти</button>
    </form>
    
    <div class="auth-links">
        Нет аккаунта? <a href="register.php">Зарегистрируйся в пару кликов!</a>
    </div>
</div>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
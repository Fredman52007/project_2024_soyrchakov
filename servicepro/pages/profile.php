<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/header.php';


// Получаем данные пользователя из БД
$db = getDB();
$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

// Получаем заявки пользователя
$stmt = $db->prepare("SELECT * FROM requests WHERE user_id = ? ORDER BY created_at DESC LIMIT 4");
$stmt->execute([$_SESSION['user_id']]);
$userRequests = $stmt->fetchAll();
?>

<div class="content">
   
    
    <div class="user-info">
        <h2><?= !empty($user['login']) ? htmlspecialchars($user['login']) : 'Имя не указано' ?></h2>
        <p>Email: <?= !empty($user['email']) ? htmlspecialchars($user['email']) : 'Нет данных' ?></p>
        <p>Телефон: <?= !empty($user['phone']) ? htmlspecialchars($user['phone']) : 'Нет данных' ?></p>
        <p>Дата регистрации: <?= !empty($user['created_at']) ? date('d.m.Y', strtotime($user['created_at'])) : 'Нет данных' ?></p>
    </div>
    
    <h2>Последние заявки</h2>
    <div class="requests-list">
        <?php if (!empty($userRequests)): ?>
            <?php foreach ($userRequests as $request): ?>
                <div class="request-item">
                    <span>Заявка #<?= htmlspecialchars($request['id']) ?></span>
                    <span><?= date('d.m.Y H:i', strtotime($request['created_at'])) ?></span>
                    <span class="status-<?= htmlspecialchars($request['status']) ?>">
                        <?= match($request['status']) {
                            'new' => 'Новая',
                            'in_progress' => 'В работе',
                            'completed' => 'Завершена',
                            default => 'Неизвестен'
                        } ?>
                    </span>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-requests">
                У вас пока нет заявок
            </div>
        <?php endif; ?>
    </div>
    
    <hr>
    
    <div class="profile-description">
        <h2>Описание профиля</h2>
        <p><?= !empty($user['description']) ? htmlspecialchars($user['description']) : 'Пользователь пока не добавил описание' ?></p>
    </div>
</div>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
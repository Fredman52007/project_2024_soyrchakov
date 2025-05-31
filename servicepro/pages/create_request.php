<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';

// Проверка авторизации
if (!isset($_SESSION['user_id'])) {
    header('Location: authpage.php');
    exit;
}

$db = getDB();
$error = '';
$success = '';

// Получаем списки услуг и пунктов
$services = $db->query("SELECT * FROM services")->fetchAll();
$points = $db->query("SELECT * FROM service_points")->fetchAll();

// Обработка формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $service_id = (int)($_POST['service_id'] ?? 0);
        $point_id = (int)($_POST['point_id'] ?? 0);
        $date = $_POST['date'] ?? '';
        $time = $_POST['time'] ?? '';
        $notes = trim($_POST['notes'] ?? '');

        // Валидация
        if (!$service_id || !$point_id || !$date || !$time) {
            throw new Exception('Пожалуйста, заполните все обязательные поля');
        }

        // Проверяем существование услуги и пункта
        $stmt = $db->prepare("SELECT id FROM services WHERE id = ?");
        $stmt->execute([$service_id]);
        if (!$stmt->fetch()) {
            throw new Exception('Выбранная услуга не существует');
        }

        $stmt = $db->prepare("SELECT id FROM service_points WHERE id = ?");
        $stmt->execute([$point_id]);
        if (!$stmt->fetch()) {
            throw new Exception('Выбранный сервисный пункт не существует');
        }

        // Создаем заявку
        $stmt = $db->prepare("INSERT INTO requests 
            (user_id, service_id, point_id, request_date, request_time, notes) 
            VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_SESSION['user_id'],
            $service_id,
            $point_id,
            $date,
            $time,
            $notes
        ]);
        
        $success = 'Заявка успешно создана!';
        $_POST = []; // Очищаем форму после успешной отправки
        
    } catch (Exception $e) {
        $error = 'Ошибка при создании заявки: ' . $e->getMessage();
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="content">
   
    <h2>Создайте заявку!</h2>

    <?php if ($error): ?>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="success-message"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="POST" class="request-form">
        <div class="form-group">
            <label for="date">Дата:</label>
            <input type="date" id="date" name="date" required 
                   min="<?= date('Y-m-d') ?>" 
                   value="<?= htmlspecialchars($_POST['date'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label for="time">Время:</label>
            <input type="time" id="time" name="time" required
                   min="09:00" max="20:00"
                   value="<?= htmlspecialchars($_POST['time'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label for="service_id">Выберите услугу:</label>
            <select id="service_id" name="service_id" required>
                <option value="">-- Выберите услугу --</option>
                <?php foreach ($services as $service): ?>
                    <option value="<?= $service['id'] ?>" 
                        <?= ($_POST['service_id'] ?? '') == $service['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($service['name']) ?> 
                        (<?= $service['price'] ?> руб)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="point_id">Выберите пункт:</label>
            <select id="point_id" name="point_id" required>
                <option value="">-- Выберите пункт --</option>
                <?php foreach ($points as $point): ?>
                    <option value="<?= $point['id'] ?>"
                        <?= ($_POST['point_id'] ?? '') == $point['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($point['name']) ?> 
                        (<?= htmlspecialchars($point['address']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="notes">Дополнительная информация:</label>
            <textarea id="notes" name="notes"><?= htmlspecialchars($_POST['notes'] ?? '') ?></textarea>
        </div>

        <button type="submit" class="btn">Оставить заявку!</button>
    </form>
</div>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
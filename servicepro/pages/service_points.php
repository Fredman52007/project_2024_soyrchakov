<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/header.php';

try {
    $db = getDB();
    
    // Проверяем существование столбца area
    $stmt = $db->query("SHOW COLUMNS FROM service_points LIKE 'area'");
    if (!$stmt->fetch()) {
        throw new Exception('Столбец area не существует в таблице service_points');
    }

    // Получаем список пунктов
    $pointsByArea = $db->query("
        SELECT area, GROUP_CONCAT(name SEPARATOR '|') as locations 
        FROM service_points 
        GROUP BY area
    ")->fetchAll(PDO::FETCH_KEY_PAIR);

} catch (PDOException $e) {
    die("Ошибка базы данных: " . $e->getMessage());
} catch (Exception $e) {
    die($e->getMessage());
}
?>

<div class="content">
   
    <h2>Наши пункты приёма/выдачи!</h2>

    <?php if (!empty($pointsByArea)): ?>
        <div class="service-points-container">
            <?php foreach ($pointsByArea as $area => $locations): ?>
                <div class="area-section">
                    <h3 class="area-title"><?= htmlspecialchars($area) ?></h3>
                    <ul class="locations-list">
                        <?php foreach (explode('|', $locations) as $location): ?>
                            <li><?= htmlspecialchars($location) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="no-data">Нет данных о пунктах выдачи</p>
    <?php endif; ?>
        <h2>карта</h2>
    <div class="map-container" id="map">
       <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Ac9ff9b6af01a5b92d79e6e14f936b588cb68583474be2a00b53b46f0035aa501&amp;width=980&amp;height=500&amp;lang=ru_RU&amp;scroll=true"></script>
    </div>
</div>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
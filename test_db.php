<?php
declare(strict_types=1);

// Simple DB connection tester — uses config/config.php constants
// Place this file in the project root and open it in the browser to test the DB.

require __DIR__ . '/config/config.php';

echo '<pre>';
echo "Testing DB connection using:\n";
echo "DB_HOST=" . DB_HOST . "\n";
echo "DB_NAME=" . DB_NAME . "\n";
echo "DB_USER=" . DB_USER . "\n";

try {
    $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', DB_HOST, DB_NAME);
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    $stmt = $pdo->query('SELECT NOW() AS now');
    $row = $stmt->fetch();
    echo "Connection successful. Server time: " . ($row['now'] ?? 'unknown') . "\n";
    // Show a count of users as a sanity check if table exists
    $res = $pdo->query("SELECT COUNT(*) AS c FROM information_schema.tables WHERE table_schema = '" . DB_NAME . "'");
    $t = $res->fetch();
    echo "Tables present in DB: " . ($t['c'] ?? '0') . "\n";
} catch (PDOException $e) {
    echo "Connection failed: " . htmlspecialchars($e->getMessage()) . "\n";
}

echo '</pre>';

<?php
// inc/db.php
// Conexiune PDO la MySQL (XAMPP: user=root, parola goală, DB: proiect_php)

$DB_HOST = '127.0.0.1';
$DB_NAME = 'proiect_php';
$DB_USER = 'root';
$DB_PASS = '';        // la XAMPP de obicei e gol

$dsn = "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // aruncă excepții
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // fetch asoc.
    PDO::ATTR_EMULATE_PREPARES   => false,                  // prepared reale
];

try {
    $pdo = new PDO($dsn, $DB_USER, $DB_PASS, $options);
} catch (PDOException $e) {
    http_response_code(500);
    echo "<h1>Eroare conexiune DB</h1>";
    echo "<pre>" . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "</pre>";
    exit;
}

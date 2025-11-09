<?php
require __DIR__ . '/inc/db.php';

$username = 'admin';
$plain    = 'admin123';

$exists = $pdo->prepare("SELECT id FROM users WHERE username=:u");
$exists->execute([':u'=>$username]);

if ($exists->fetch()) {
    echo "Utilizatorul '$username' există deja.";
    exit;
}

$hash = password_hash($plain, PASSWORD_DEFAULT);
$ins = $pdo->prepare("INSERT INTO users(username, password_hash) VALUES(:u,:p)");
$ins->execute([':u'=>$username, ':p'=>$hash]);

echo "Creat utilizator: $username / parolă: $plain";

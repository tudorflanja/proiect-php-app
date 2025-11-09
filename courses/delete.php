<?php
require __DIR__ . '/../inc/header.php';
require_login();
$id = (int)($_GET['id'] ?? 0);
if ($id > 0) {
    $stmt = $pdo->prepare("DELETE FROM courses WHERE id=:id");
    $stmt->execute([':id'=>$id]);
}
header('Location: index.php'); exit;

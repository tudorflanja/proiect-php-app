<?php
require __DIR__ . '/inc/db.php';

$stmt = $pdo->query("SELECT COUNT(*) AS c_students FROM students");
$students = $stmt->fetch();

$stmt = $pdo->query("SELECT COUNT(*) AS c_courses FROM courses");
$courses = $stmt->fetch();

$stmt = $pdo->query("SELECT COUNT(*) AS c_enr FROM enrollments");
$enr = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Test conexiune DB</title>
  <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
  <nav class="site-nav">
    <a class="brand" href="#">Proiect PHP</a>
  </nav>

  <main class="container">
    <h1>Conexiune reușită ✅</h1>
    <p>Se poate citi din baza de date <code>proiect_php</code>.</p>

    <table class="nice">
      <thead><tr><th>Tabel</th><th>Număr înregistrări</th></tr></thead>
      <tbody>
        <tr><td>students</td><td><?= (int)$students['c_students'] ?></td></tr>
        <tr><td>courses</td><td><?= (int)$courses['c_courses'] ?></td></tr>
        <tr><td>enrollments</td><td><?= (int)$enr['c_enr'] ?></td></tr>
      </tbody>
    </table>
  </main>
</body>
</html>

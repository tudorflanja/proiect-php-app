<?php
require __DIR__ . '/db.php';
require __DIR__ . '/auth.php';
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Proiect PHP</title>
  <link rel="stylesheet" href="/proiect_php_app/assets/styles.css">
</head>
<body>
<nav class="site-nav">
  <a class="brand" href="/proiect_php_app/students/index.php">Proiect PHP</a>
  <ul>
    <li><a href="/proiect_php_app/students/index.php">Students</a></li>
    <li><a href="/proiect_php_app/courses/index.php">Courses</a></li>
    <li><a href="/proiect_php_app/enrollments/index.php">Enrollments</a></li>
  </ul>
  <div style="margin-left:auto">
    <?php if (is_logged_in()): ?>
      <span>👤 <?= htmlspecialchars(current_user()['username']) ?></span>
      <a class="btn" href="/proiect_php_app/logout.php" style="margin-left:.5rem">Logout</a>
    <?php else: ?>
      <a class="btn" href="/proiect_php_app/login.php">Login</a>
    <?php endif; ?>
  </div>
</nav>
<main class="container">

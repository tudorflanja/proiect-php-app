<?php
require __DIR__ . '/inc/db.php';
require __DIR__ . '/inc/auth.php';

$error = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT id, username, password_hash FROM users WHERE username=:u");
    $stmt->execute([':u'=>$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user'] = ['id'=>$user['id'], 'username'=>$user['username']];
        $next = $_GET['next'] ?? '/proiect_php_app/students/index.php';
        header('Location: ' . $next);
        exit;
    } else {
        $error = 'Utilizator sau parolă incorecte.';
    }
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="/proiect_php_app/assets/styles.css">
</head>
<body>
<main class="container" style="max-width:520px">
  <h1>Autentificare</h1>

  <?php if ($error): ?>
    <div class="responsive-note"><ul><li><?= htmlspecialchars($error) ?></li></ul></div>
  <?php endif; ?>

  <form method="post" class="contact-form">
    <div class="field">
      <label>Username</label>
      <input name="username" value="<?= htmlspecialchars($username) ?>" required>
    </div>
    <div class="field">
      <label>Parolă</label>
      <input type="password" name="password" required>
    </div>
    <div class="actions">
      <button class="btn primary" type="submit">Intră</button>
      <a class="btn" href="/proiect_php_app/students/index.php">Înapoi</a>
    </div>
  </form>
</main>
</body>
</html>

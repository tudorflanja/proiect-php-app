<?php
require __DIR__ . '/../inc/header.php';
require_login();

$errors = [];
$name = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if ($name === '')  $errors[] = 'Numele este obligatoriu.';
    if ($email === '') $errors[] = 'Emailul este obligatoriu.';

    if (!$errors) {
        try {
            $stmt = $pdo->prepare("INSERT INTO students(name,email) VALUES(:name,:email)");
            $stmt->execute([':name' => $name, ':email' => $email]);
            header('Location: index.php');
            exit;
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') { // UNIQUE email
                $errors[] = 'Email deja folosit.';
            } else {
                $errors[] = 'Eroare DB: ' . $e->getMessage();
            }
        }
    }
}
?>
<h1>Adaugă student</h1>

<?php if ($errors): ?>
  <div class="responsive-note">
    <ul><?php foreach ($errors as $er) echo '<li>'.htmlspecialchars($er).'</li>'; ?></ul>
  </div>
<?php endif; ?>

<form method="post" class="contact-form" style="max-width:520px">
  <div class="field">
    <label>Nume</label>
    <input type="text" name="name" value="<?= htmlspecialchars($name) ?>" required>
  </div>
  <div class="field">
    <label>Email</label>
    <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
  </div>
  <div class="actions">
    <button class="btn primary" type="submit">Salvează</button>
    <a class="btn" href="index.php">Renunță</a>
  </div>
</form>

<?php require __DIR__ . '/../inc/footer.php'; ?>

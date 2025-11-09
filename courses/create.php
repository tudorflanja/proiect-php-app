<?php
require __DIR__ . '/../inc/header.php';
require_login();
$errors = [];
$title = '';
$professor = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $professor = trim($_POST['professor'] ?? '');
    if ($title === '') $errors[] = 'Titlul este obligatoriu.';

    if (!$errors) {
        $stmt = $pdo->prepare("INSERT INTO courses(title, professor) VALUES(:t,:p)");
        $stmt->execute([':t'=>$title, ':p'=>$professor ?: null]);
        header('Location: index.php'); exit;
    }
}
?>
<h1>Adaugă curs</h1>

<?php if ($errors): ?>
<div class="responsive-note"><ul><?php foreach($errors as $e) echo '<li>'.htmlspecialchars($e).'</li>'; ?></ul></div>
<?php endif; ?>

<form method="post" class="contact-form" style="max-width:520px">
  <div class="field"><label>Titlu</label><input name="title" value="<?= htmlspecialchars($title) ?>" required></div>
  <div class="field"><label>Profesor</label><input name="professor" value="<?= htmlspecialchars($professor) ?>"></div>
  <div class="actions">
    <button class="btn primary">Salvează</button>
    <a class="btn" href="index.php">Înapoi</a>
  </div>
</form>
<?php require __DIR__ . '/../inc/footer.php'; ?>

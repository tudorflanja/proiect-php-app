<?php
require __DIR__ . '/../inc/header.php';
require_login();
$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM courses WHERE id=:id");
$stmt->execute([':id'=>$id]);
$c = $stmt->fetch();
if (!$c) { http_response_code(404); echo "<h1>Curs inexistent</h1>"; require __DIR__ . '/../inc/footer.php'; exit; }

$errors = [];
$title = $c['title'];
$professor = $c['professor'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $professor = trim($_POST['professor'] ?? '');
    if ($title === '') $errors[] = 'Titlul este obligatoriu.';

    if (!$errors) {
        $stmt = $pdo->prepare("UPDATE courses SET title=:t, professor=:p WHERE id=:id");
        $stmt->execute([':t'=>$title, ':p'=>$professor ?: null, ':id'=>$id]);
        header('Location: index.php'); exit;
    }
}
?>
<h1>Editează curs #<?= (int)$id ?></h1>

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

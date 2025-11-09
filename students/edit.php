<?php
require __DIR__ . '/../inc/header.php';
require_login();

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM students WHERE id=:id");
$stmt->execute([':id' => $id]);
$student = $stmt->fetch();

if (!$student) {
    http_response_code(404);
    echo "<h1>Student inexistent</h1>";
    require __DIR__ . '/../inc/footer.php';
    exit;
}

$errors = [];
$name = $student['name'];
$email = $student['email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if ($name === '')  $errors[] = 'Numele este obligatoriu.';
    if ($email === '') $errors[] = 'Emailul este obligatoriu.';

    if (!$errors) {
        try {
            $stmt = $pdo->prepare("UPDATE students SET name=:name, email=:email WHERE id=:id");
            $stmt->execute([':name'=>$name, ':email'=>$email, ':id'=>$id]);
            header('Location: index.php');
            exit;
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                $errors[] = 'Email deja folosit de alt student.';
            } else {
                $errors[] = 'Eroare DB: ' . $e->getMessage();
            }
        }
    }
}
?>
<h1>Editează student #<?= (int)$id ?></h1>

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
    <a class="btn" href="index.php">Înapoi</a>
  </div>
</form>

<?php require __DIR__ . '/../inc/footer.php'; ?>

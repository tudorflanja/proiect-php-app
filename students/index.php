<?php require __DIR__ . '/../inc/header.php';
require_login();

// căutare
$q = isset($_GET['q']) ? trim($_GET['q']) : '';
if ($q !== '') {
    $stmt = $pdo->prepare("SELECT * FROM students
                           WHERE name LIKE :q OR email LIKE :q
                           ORDER BY id DESC");
    $stmt->execute([':q' => "%$q%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM students ORDER BY id DESC");
}
$rows = $stmt->fetchAll();

// contor total
$total = $pdo->query("SELECT COUNT(*) FROM students")->fetchColumn();
?>
<h1>Students (<?= (int)$total ?>)</h1>

<form method="get" class="contact-form" style="gap:.5rem; grid-template-columns:1fr auto;">
  <input type="text" name="q" placeholder="Caută după nume/email" value="<?= htmlspecialchars($q) ?>">
  <button class="btn">Caută</button>
</form>

<p>
  <a class="btn primary" href="create.php">+ Adaugă student</a>
</p>

<table class="nice">
  <thead>
    <tr><th>#</th><th>Nume</th><th>Email</th><th>Creat la</th><th>Acțiuni</th></tr>
  </thead>
  <tbody>
  <?php foreach ($rows as $r): ?>
    <tr>
      <td><?= (int)$r['id'] ?></td>
      <td><?= htmlspecialchars($r['name']) ?></td>
      <td><?= htmlspecialchars($r['email']) ?></td>
      <td><?= htmlspecialchars($r['created_at']) ?></td>
      <td>
        <a class="btn" href="edit.php?id=<?= (int)$r['id'] ?>">Editează</a>
        <a class="btn" href="delete.php?id=<?= (int)$r['id'] ?>" onclick="return confirm('Ștergi acest student? Toate înscrierile aferente vor fi șterse (CASCADE).');">Șterge</a>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<?php require __DIR__ . '/../inc/footer.php'; ?>

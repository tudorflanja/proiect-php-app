<?php require __DIR__ . '/../inc/header.php';
require_login();

$q = isset($_GET['q']) ? trim($_GET['q']) : '';
if ($q !== '') {
    $stmt = $pdo->prepare("SELECT * FROM courses
                           WHERE title LIKE :q OR professor LIKE :q
                           ORDER BY id DESC");
    $stmt->execute([':q' => "%$q%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM courses ORDER BY id DESC");
}
$rows = $stmt->fetchAll();
$total = $pdo->query("SELECT COUNT(*) FROM courses")->fetchColumn();
?>
<h1>Courses (<?= (int)$total ?>)</h1>

<form method="get" class="contact-form" style="gap:.5rem; grid-template-columns:1fr auto;">
  <input type="text" name="q" placeholder="Caută după titlu/profesor" value="<?= htmlspecialchars($q) ?>">
  <button class="btn">Caută</button>
</form>

<p><a class="btn primary" href="create.php">+ Adaugă curs</a></p>

<table class="nice">
  <thead>
    <tr><th>#</th><th>Titlu</th><th>Profesor</th><th>Creat la</th><th>Acțiuni</th></tr>
  </thead>
  <tbody>
  <?php foreach ($rows as $r): ?>
    <tr>
      <td><?= (int)$r['id'] ?></td>
      <td><?= htmlspecialchars($r['title']) ?></td>
      <td><?= htmlspecialchars($r['professor']) ?></td>
      <td><?= htmlspecialchars($r['created_at']) ?></td>
      <td>
        <a class="btn" href="edit.php?id=<?= (int)$r['id'] ?>">Editează</a>
        <a class="btn" href="delete.php?id=<?= (int)$r['id'] ?>" onclick="return confirm('Ștergi acest curs? Înscrierile aferente se vor șterge (CASCADE).');">Șterge</a>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<?php require __DIR__ . '/../inc/footer.php'; ?>

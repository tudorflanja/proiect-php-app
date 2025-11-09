<?php
require __DIR__ . '/../inc/header.php';
require_login();

// JOIN pentru a afișa numele studentului și cursul
$stmt = $pdo->query("
  SELECT e.id, s.name AS student_name, c.title AS course_title, e.enroll_date
  FROM enrollments e
  JOIN students s ON s.id = e.student_id
  JOIN courses c  ON c.id = e.course_id
  ORDER BY e.id DESC
");
$rows = $stmt->fetchAll();

$total = $pdo->query("SELECT COUNT(*) FROM enrollments")->fetchColumn();
?>

<h1>Enrollments (<?= (int)$total ?>)</h1>

<p><a class="btn primary" href="create.php">+ Adaugă înscriere</a></p>

<table class="nice">
  <thead>
    <tr><th>#</th><th>Student</th><th>Curs</th><th>Data înscrierii</th><th>Acțiuni</th></tr>
  </thead>
  <tbody>
  <?php foreach ($rows as $r): ?>
    <tr>
      <td><?= (int)$r['id'] ?></td>
      <td><?= htmlspecialchars($r['student_name']) ?></td>
      <td><?= htmlspecialchars($r['course_title']) ?></td>
      <td><?= htmlspecialchars($r['enroll_date']) ?></td>
      <td>
        <a class="btn" href="delete.php?id=<?= (int)$r['id'] ?>" onclick="return confirm('Sigur ștergi această înscriere?');">Șterge</a>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<?php require __DIR__ . '/../inc/footer.php'; ?>

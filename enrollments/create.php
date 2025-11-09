<?php
require __DIR__ . '/../inc/header.php';
require_login();

// Preluăm listele de studenți și cursuri
$students = $pdo->query("SELECT id, name FROM students ORDER BY name")->fetchAll();
$courses  = $pdo->query("SELECT id, title FROM courses ORDER BY title")->fetchAll();

$errors = [];
$student_id = '';
$course_id  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = (int)($_POST['student_id'] ?? 0);
    $course_id  = (int)($_POST['course_id'] ?? 0);

    if ($student_id <= 0) { $errors[] = 'Selectează un student.'; }
    if ($course_id  <= 0) { $errors[] = 'Selectează un curs.'; }

    if (!$errors) {
        // verificare unicitate pereche (student_id, course_id)
        $check = $pdo->prepare("SELECT COUNT(*) FROM enrollments WHERE student_id=:s AND course_id=:c");
        $check->execute([':s' => $student_id, ':c' => $course_id]);
        if ($check->fetchColumn() > 0) {
            $errors[] = 'Această înscriere există deja.';
        }
    }

    if (!$errors) {
        $stmt = $pdo->prepare("INSERT INTO enrollments(student_id, course_id) VALUES(:s, :c)");
        $stmt->execute([':s' => $student_id, ':c' => $course_id]);
        header('Location: index.php');
        exit;
    }
}
?>
<h1>Adaugă înscriere</h1>

<?php if ($errors): ?>
  <div class="responsive-note">
    <ul>
      <?php foreach ($errors as $e): ?>
        <li><?= htmlspecialchars($e) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<form method="post" class="contact-form" style="max-width:520px">
  <div class="field">
    <label>Student</label>
    <select name="student_id" required>
      <option value="">— Alege —</option>
      <?php foreach ($students as $s): ?>
        <option value="<?= (int)$s['id'] ?>" <?= ((int)$s['id'] === (int)$student_id) ? 'selected' : '' ?>>
          <?= htmlspecialchars($s['name']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="field">
    <label>Curs</label>
    <select name="course_id" required>
      <option value="">— Alege —</option>
      <?php foreach ($courses as $c): ?>
        <option value="<?= (int)$c['id'] ?>" <?= ((int)$c['id'] === (int)$course_id) ? 'selected' : '' ?>>
          <?= htmlspecialchars($c['title']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="actions">
    <button class="btn primary" type="submit">Salvează</button>
    <a class="btn" href="index.php">Înapoi</a>
  </div>
</form>

<?php require __DIR__ . '/../inc/footer.php'; ?>

<?php
// public/login.php
global $pdo;
session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../modules/auth.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $errors[] = 'Both fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    } else {
        $res = login_user($pdo, $email, $password);
        if ($res['success']) {
            header('Location: dashboard.php');
            exit;
        } else {
            $errors[] = $res['message'];
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Staff Portal — Login</title>
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <link rel="stylesheet" href="assets/css/styles.css" />
</head>
<body class="auth-page">
  <main class="auth-container">
    <div class="card auth-card">
      <h1>Staff Portal</h1>
      <p class="muted">Sign in with your staff credentials</p>

      <?php if (!empty($errors)): ?>
        <div class="errors">
          <?php foreach($errors as $err): ?>
            <div class="error"><?=htmlspecialchars($err)?></div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <form method="post" novalidate>
        <label>Email
          <input type="email" name="email" required value="<?=isset($email) ? htmlspecialchars($email) : ''?>">
        </label>

        <label>Password
          <input type="password" name="password" required>
        </label>

        <button type="submit" class="btn">Login</button>
      </form>

      <div class="help">
        <small>Use the seeded admin account or ask an administrator to create your account.</small>
      </div>
    </div>
  </main>
</body>
</html>

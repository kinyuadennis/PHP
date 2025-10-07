<?php

// modules/auth.php
// Functions expect a $pdo (PDO instance) supplied by including config/db.php

function get_user_by_email(PDO $pdo, string $email)
{
    $stmt = $pdo->prepare("SELECT u.*, r.role_name FROM users u JOIN roles r ON u.role_id = r.id WHERE u.email = ?");
    $stmt->execute([$email]);
    return $stmt->fetch();
}

function login_user(PDO $pdo, string $email, string $password): array
{
    $user = get_user_by_email($pdo, $email);
    if (!$user) {
        return ['success' => false, 'message' => 'No account found with that email.'];
    }

    if (!password_verify($password, $user['password'])) {
        return ['success' => false, 'message' => 'Incorrect password.'];
    }

    // ensure session started
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();

    // security: regenerate session id on login
    session_regenerate_id(true);

    // store small user info in session
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['name'] = $user['name'];
    $_SESSION['role_id'] = $user['role_id'];
    $_SESSION['role_name'] = $user['role_name'];

    return ['success' => true, 'message' => 'Logged in'];
}

function logout_user()
{
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    // clear session
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
}

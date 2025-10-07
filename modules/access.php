<?php
// modules/access.php

function require_login(string $redirect = 'login.php')
{
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: ' . $redirect);
        exit;
    }
}

function require_role($allowed_roles)
{
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    if (!isset($_SESSION['role_name'])) {
        header('Location: login.php');
        exit;
    }
    $userRole = $_SESSION['role_name'];
    if (is_array($allowed_roles)) {
        if (!in_array($userRole, $allowed_roles)) {
            http_response_code(403);
            echo "<h2>Access denied</h2><p>You don't have access to this page.</p>";
            exit;
        }
    } else {
        if ($userRole !== $allowed_roles) {
            http_response_code(403);
            echo "<h2>Access denied</h2><p>You don't have access to this page.</p>";
            exit;
        }
    }
}


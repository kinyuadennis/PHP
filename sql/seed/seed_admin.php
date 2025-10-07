<?php
// seed/seed_admin.php
global $pdo;
require_once __DIR__ . '/../config/db.php';

$name = 'Admin User';
$email = 'admin@example.com';
$plain = 'Admin123!'; // change this immediately after login

// find admin role id
$stmt = $pdo->prepare("SELECT id FROM roles WHERE role_name = ?");
$stmt->execute(['Admin']);
$role_id = $stmt->fetchColumn();

if(!$role_id){
    echo "Admin role not found. Make sure roles were seeded.\n";
    exit;
}

// check if user exists
$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$email]);
if($stmt->fetchColumn()){
    echo "Admin user already exists: $email\n";
    exit;
}

// create user with hashed password
$hash = password_hash($plain, PASSWORD_DEFAULT);
$ins = $pdo->prepare("INSERT INTO users (name, email, password, role_id, department) VALUES (?, ?, ?, ?, ?)");
$ins->execute([$name, $email, $hash, $role_id, 'Management']);

echo "Created admin user: $email (password: $plain)\n";

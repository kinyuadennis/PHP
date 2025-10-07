<?php

// config/db.php
$host = '127.0.0.1';
$db = 'project_db';
$user = 'root';
$pass = ''; // change if your MySQL has a password
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // In production do not reveal exception details
    exit('Database connection failed: ' . $e->getMessage());
}


<?php
// public/logout.php
require_once __DIR__ . '/../modules/auth.php';
logout_user();
header('Location: login.php');
exit;


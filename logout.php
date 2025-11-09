<?php
require __DIR__ . '/inc/auth.php';
$_SESSION = [];
session_destroy();
header('Location: /proiect_php_app/login.php');
exit;

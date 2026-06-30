<?php
$host = 'localhost';
$user = 'root';
$pass = 'Shruthi@30';
$db   = 'analytics_db';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    error_log('DB connection failed: ' . $conn->connect_error);
    die('Service temporarily unavailable.');
}
?>
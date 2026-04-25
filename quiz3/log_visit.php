<?php
include('db.php');

// Capture the data we want to log
$page      = isset($_GET['page']) ? $_GET['page'] : 'unknown';
$ip        = $_SERVER['REMOTE_ADDR'];
$agent     = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';

// Prepared statement — NEVER concatenate user input directly into SQL
$stmt = $conn->prepare(
    "INSERT INTO page_visits (page_url, ip_address, user_agent) VALUES (?, ?, ?)"
);
$stmt->bind_param("sss", $page, $ip, $agent);
$stmt->execute();
$stmt->close();
$conn->close();

// Return a tiny transparent pixel so this can be called as an image src
header('Content-Type: image/gif');
echo base64_decode('R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7');
exit;
?>
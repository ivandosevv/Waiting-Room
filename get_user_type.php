<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_type'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
} else {
    echo json_encode(['success' => true, 'userType' => $_SESSION['user_type']]);
}
?>

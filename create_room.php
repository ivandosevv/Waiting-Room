<?php
include 'database.php';

header('Content-Type: application/json');

try {
    $json_obj = json_decode(file_get_contents('php://input'), true);

    // $link = $json_obj['link'];
    // $subject = $json_obj['subject'];
    // $teacherId = $json_obj['user_id'];
    // $lastName = $json_obj['last_name'];
    // $email = $json_obj['email'];
    // $userType = $json_obj['userType'];

    if ($_SESSION['user_type'] !== 'teacher') {
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        exit;
    }

    $link = $_POST['link'];
    $subject = $_POST['subject'];
    $username = $_SESSION['username'];

    $stmt = $conn->prepare("INSERT INTO room (link, subject, next_number, teacher_username, status) VALUES (:link, :subject, 1, :username, 'waiting')");
    $stmt->bindParam(':link', $link);
    $stmt->bindParam(':subject', $subject);
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    echo json_encode(['success' => true]);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>

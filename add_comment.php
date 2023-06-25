<?php
include 'database.php';

header('Content-Type: application/json');

try {
    $roomId = $_POST['roomId'];
    $userId = $_SESSION['user_id'];
    $comment = $_POST['comment'];

    $userType = $_SESSION['user_type'];
    $tableName = ($userType === 'student') ? 'student_comment' : 'teacher_comment';

    $stmt = $conn->prepare("INSERT INTO $tableName (room_id, user_id, comment) VALUES (:roomId, :userId, :comment)");
    $stmt->bindParam(':roomId', $roomId);
    $stmt->bindParam(':userId', $userId);
    $stmt->bindParam(':comment', $comment);
    $stmt->execute();

    echo json_encode(['success' => true]);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>

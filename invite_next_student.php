<?php
include 'database.php';

header('Content-Type: application/json');

try {
    $roomId = $_POST['roomId'];
    // Inside invite_next_student.php and invite_student_by_number.php
if ($_SESSION['user_type'] !== 'teacher') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}


    $stmt = $conn->prepare("SELECT student_id FROM room_student WHERE room_id = :roomId ORDER BY queue_position ASC LIMIT 1");
    $stmt->bindParam(':roomId', $roomId);
    $stmt->execute();
    $studentId = $stmt->fetchColumn();

    $stmt = $conn->prepare("UPDATE room_student SET status = 'invited' WHERE room_id = :roomId AND student_id = :studentId");
    $stmt->bindParam(':roomId', $roomId);
    $stmt->bindParam(':studentId', $studentId);
    $stmt->execute();

    echo json_encode(['success' => true]);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>

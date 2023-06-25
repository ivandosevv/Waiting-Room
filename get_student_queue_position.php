<?php
include 'database.php';

header('Content-Type: application/json');

try {
    $roomId = $_GET['roomId'];
    $studentId = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT COUNT(*) as position FROM room_student WHERE room_id = :roomId AND id <= (SELECT id FROM room_student WHERE room_id = :roomId AND student_id = :studentId)");
    $stmt->bindParam(':roomId', $roomId);
    $stmt->bindParam(':studentId', $studentId);
    $stmt->execute();
    $row = $stmt->fetch();

    echo json_encode(['success' => true, 'position' => $row['position']]);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>

<?php
include 'database.php';

header('Content-Type: application/json');

try {
    $roomId = $_POST['roomId'];
    $queueNumber = $_POST['queueNumber'];

    // Inside invite_next_student.php and invite_student_by_number.php
if ($_SESSION['user_type'] !== 'teacher') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}


    $stmt = $conn->prepare("UPDATE room_student SET status = 'invited' WHERE room_id = :roomId AND queue_position = :queueNumber");
    $stmt->bindParam(':roomId', $roomId);
    $stmt->bindParam(':queueNumber', $queueNumber);
    $stmt->execute();

    echo json_encode(['success' => true]);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>

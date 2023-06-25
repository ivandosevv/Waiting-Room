<?php
include 'database.php';

header('Content-Type: application/json');

try {
    $stmt = $conn->prepare("SELECT id FROM room WHERE teacher_username = :teacher_username");
    $stmt->bindParam(':teacher_username', $_SESSION['username']);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $roomId = $result['id'];

        $stmt = $conn->prepare("SELECT * FROM room_student WHERE room_id = :roomId ORDER BY queue_number ASC");
        $stmt->bindParam(':roomId', $roomId);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $queueList = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(['success' => true, 'queueList' => $queueList]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No students in queue']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Room not found']);
    }
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>

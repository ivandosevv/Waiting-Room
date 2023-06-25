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
    
        $stmt = $conn->prepare("SELECT MIN(queue_number) AS next_number FROM room_student WHERE room_id = :roomId");
        $stmt->bindParam(':roomId', $roomId);
        $stmt->execute();

        $nextNumber = $stmt->fetchColumn();

        if ($nextNumber === false) {
            $nextNumber = 1; // If there are no students in the queue, the next number is 1.
        }

        echo json_encode(['success' => true, 'nextNumber' => $nextNumber]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Room not found']);
    }
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>

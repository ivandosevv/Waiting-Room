<?php
include 'database.php';

header('Content-Type: application/json');

try {
    $student_username = $_POST['student_username'];

    $stmt = $conn->prepare("SELECT id FROM room WHERE teacher_username = :teacher_username");
    $stmt->bindParam(':teacher_username', $_SESSION['username']);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $roomId = $result['id'];

        // Get the last datetime entry and queue number
        $stmt = $conn->prepare("SELECT MAX(datetime_entry) AS last_datetime_entry, MAX(queue_number) AS last_queue_number FROM room_student WHERE room_id = :roomId");
        $stmt->bindParam(':roomId', $roomId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // If there's no students in the queue, allow user to set datetime entry
        if ($result['last_datetime_entry'] === NULL) {
            $datetime_entry = $_POST['datetime_entry'];
            $queueNumber = 1;
        } else {
            // Else add 15 minutes to the last datetime entry
            $last_datetime = new DateTime($result['last_datetime_entry']);
            $last_datetime->add(new DateInterval('PT15M'));
            $datetime_entry = $last_datetime->format('Y-m-d H:i:s');
            $queueNumber = $result['last_queue_number'] + 1;
        }

        $stmt = $conn->prepare("INSERT INTO room_student (room_id, student_username, datetime_entry, queue_number) VALUES (:roomId, :student_username, :datetime_entry, :queue_number)");
        $stmt->bindParam(':roomId', $roomId);
        $stmt->bindParam(':student_username', $student_username);
        $stmt->bindParam(':datetime_entry', $datetime_entry);
        $stmt->bindParam(':queue_number', $queueNumber);
        $stmt->execute();

        echo json_encode(['success' => true, 'datetime_entry' => $datetime_entry]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Room not found']);
    }
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>

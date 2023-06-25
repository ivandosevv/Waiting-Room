<?php
include 'database.php';

header('Content-Type: application/json');

try {
    $roomId = $_GET['roomId'];
    
    $stmt = $conn->prepare("SELECT * FROM comments WHERE room_id = :roomId");
    $stmt->bindParam(':roomId', $roomId);
    $stmt->execute();

    $comments = $stmt->fetchAll();

    echo json_encode(['success' => true, 'comments' => $comments]);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>

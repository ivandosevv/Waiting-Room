<?php
$servername = "localhost";
$username = "root";
$password = "root1234";
$dbname = "virtual_reception_db";

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    session_start();
    $currentUsername = $_SESSION['username']; 

    $formQueue = $_POST['queue']; 
    $student1 = $_POST['student1'];
    $student2 = $_POST['student2'];

    // Note: This is a simple swap operation and assumes that each student appears in the queue only once.
    // More complex queue operations may require more sophisticated logic.
    $sql = "UPDATE Queues 
            SET username = (CASE WHEN username = :student1 THEN :student2 
                                WHEN username = :student2 THEN :student1 
                                ELSE username END)
            WHERE queue = :queue AND professor = :professor AND (username = :student1 OR username = :student2)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':student1', $student1);
    $stmt->bindParam(':student2', $student2);
    $stmt->bindParam(':queue', $formQueue);
    $stmt->bindParam(':professor', $currentUsername);

    $stmt->execute();

    echo "Queue operation successful";
} catch(PDOException $e) {
    error_log($e->getMessage());
    echo "An error occurred. Please try again.";
}

$conn = null;
?>

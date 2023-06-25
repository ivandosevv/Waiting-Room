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
    $formAction = $_POST['action']; 

    if($formAction == "create") {
        $sql = "INSERT INTO Queues (queue, professor) VALUES (:queue, :professor)";
    } else if($formAction == "delete") {
        $sql = "DELETE FROM Queues WHERE queue = :queue AND professor = :professor";
    } else {
        throw new Exception("Invalid action.");
    }

    $stmt = $conn->prepare($sql);
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

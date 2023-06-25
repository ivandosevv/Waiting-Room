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

    $sql = "DELETE FROM Queues WHERE username = :username AND queue = :queue";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $currentUsername);
    $stmt->bindParam(':queue', $formQueue);

    $stmt->execute();

    echo "User successfully removed from queue";
} catch(PDOException $e) {
    error_log($e->getMessage());
    echo "An error occurred. Please try again.";
}

$conn = null;
?>

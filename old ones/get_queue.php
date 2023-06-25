<?php
$servername = "localhost";
$username = "root";
$password = "root1234";
$dbname = "virtual_reception_db";

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    $formQueue = $_GET['queue']; // The queue the user wants to view.

    $sql = "SELECT username FROM Queues WHERE queue = '$formQueue'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $queue = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($queue);
} catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
?>

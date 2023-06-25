<?php
$servername = "localhost";
$username = "root";
$password = "root1234";
$dbname = "virtual_reception_db";

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    session_start();
    $currentUsername = $_SESSION['username']; // The user should be logged in to be added to a queue.

    $formQueue = $_POST['queue']; // The queue to which the user wants to be added.

    $sql = "INSERT INTO Queues (username, queue) VALUES ('$currentUsername', '$formQueue')";
    $conn->exec($sql);

    echo "User successfully added to queue";
} catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
?>

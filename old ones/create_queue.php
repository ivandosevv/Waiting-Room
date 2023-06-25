<?php
$host = '127.0.0.1';
$username = "root";
$password = "root1234";
$dbname = "virtual_reception_db";
$port = "3306";
$charset = 'utf8mb4';

$options = [
    \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
    \PDO::ATTR_EMULATE_PREPARES   => false,
];

// Create a new PDO instance.
$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=$charset;port=$port", $username, $password, $options);

// Set the PDO error mode to exception.
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO queues (teacher_id, queue_name, purpose, link, access_code)
VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("issss", $_SESSION['teacher_id'], $_POST['queue_name'], $_POST['purpose'], $_POST['link'], $_POST['access_code']);

if ($stmt->execute()) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

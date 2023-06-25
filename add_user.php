<?php
session_start();

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

$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

header('Content-Type: application/json');

$json_obj = json_decode(file_get_contents('php://input'), true);

$username = $json_obj['username'];
$password = $json_obj['password'];
$firstName = $json_obj['first_name'];
$lastName = $json_obj['last_name'];
$email = $json_obj['email'];
$userType = $json_obj['userType'];

$table = '';
if ($userType == "student") {
    $table = 'student';
} elseif ($userType == "teacher") {
    $table = 'teacher';
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid user type']);
    exit();
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

try {
    $stmt = $conn->prepare("INSERT INTO $table (username, password, first_name, last_name, email) 
                            VALUES (:username, :password, :first_name, :last_name, :email)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':first_name', $firstName);
    $stmt->bindParam(':last_name', $lastName);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    echo json_encode(['success' => true]);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>

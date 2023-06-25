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
$userType = $json_obj['userType'];

$table = '';
switch ($userType) {
    case 'student':
        $table = 'student';
        break;
    case 'teacher':
        $table = 'teacher';
        break;
    case 'admin':
        $table = 'admin';
        break;
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid user type']);
        exit();
}

try {
    $stmt = $conn->prepare("SELECT id, username, password FROM $table WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_type'] = $userType;
        $_SESSION['username'] = $username;
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Incorrect username or password']);
    }
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>

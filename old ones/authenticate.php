<?php
// Start the session.
session_start();

// Connect to the database.
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

try {
    $formUsername = $_POST['username'];
    $formPassword = $_POST['password'];

    // Get the user from the database
    $sql = "SELECT * FROM Users WHERE username = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $formUsername);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($formPassword, $user['password'])) {
        // The user is authenticated.
        $_SESSION['username'] = $formUsername;
        header("Location: main.html");
        exit();
    } else {
        $_SESSION['login_error'] = "Username or password is incorrect.";
        header("Location: login.html?error=Entered+credentials+do+not+match.");
        exit();
    }
}
catch(PDOException $e) {
    error_log($e->getMessage());
    $_SESSION['login_error'] = "An error occurred. Please try again.";
    header("Location: login.html");
    exit();
}

$conn = null;
?>

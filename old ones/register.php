<?php
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

// Set the PDO error mode to exception.
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    // Retrieve user data from the form.
    $formUsername = $_POST['username'];
    $formEmail = $_POST['email'];
    $formPassword = $_POST['password'];

    if(empty($formUsername) || empty($formEmail) || empty($formPassword)) {
        throw new Exception("All fields are required.");
    }

    // Prepare an SQL statement with placeholders
    $stmt = $conn->prepare("INSERT INTO $table (username, password, first_name, last_name, email) 
                            VALUES (:username, :password, :first_name, :last_name, :email)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':first_name', $firstName);
    $stmt->bindParam(':last_name', $lastName);
    $stmt->bindParam(':email', $email);

    // Execute the prepared statement
    $stmt->execute();

    header("Location: login.html");
    exit();
}
catch(PDOException $e) {
    if ($e->errorInfo[1] == 1062) {
        // Duplicate entry
        header("Location: registration.html?error=This+user+has+already+been+registered.");
        exit();
    } else {
        error_log($e->getMessage());
        echo "An error occurred. Please try again.";
        echo $sql . "<br>" . $e->getMessage();
    }
}

$conn = null;
?>

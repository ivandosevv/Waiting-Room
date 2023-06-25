<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
</head>
<body>
<form method="POST" action="register.php">
    <!-- Your form fields here -->
    <input type="text" name="username" required>
    <input type="email" name="email" required>
    <input type="password" name="password" required>
    <input type="submit" value="Register">
</form>

<?php
if (isset($_SESSION['error'])) {
    echo '<div class="alert">' . $_SESSION['error'] . '</div>';
    unset($_SESSION['error']);  // So it doesn't persist across pages
}
?>

</body>
</html>

<?php

// Unset all session variables.
$_SESSION = array();

// Destroy the session.
session_destroy();

header('Location: login.html');
exit;
?>

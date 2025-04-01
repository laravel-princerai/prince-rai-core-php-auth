<?php
session_start();

// Check if the user is logged in (i.e., token is set in the session)
if (!isset($_SESSION['jwt_token'])) {
    header("Location: login.html");  // Redirect to the login page if not logged in
    exit();
}

echo "<h1>Welcome to the Protected Page</h1>";
echo "<p>You have successfully logged in!</p>";
?>

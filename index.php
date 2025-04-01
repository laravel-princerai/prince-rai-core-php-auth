<?php
session_start();
require 'vendor/autoload.php';

use CoreAuth\Auth;
use CoreAuth\Database; // Include the Database class

// Create the Database object
$database = new Database();

// Pass the Database object to the Auth class constructor
$auth = new Auth($database);

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action == 'register' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle registration logic
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($auth->register($name, $email, $password)) {
        echo "User registered successfully!";
    } else {
        echo "Failed to register user!";
    }
}

if ($action == 'login' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle login logic
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = $auth->login($email, $password);
    if ($user) {
        // Save JWT token in session
        $_SESSION['jwt_token'] = $user['token'];  // Save the JWT token in session
        header("Location: protected.php");  // Redirect to the protected page
        exit();
    } else {
        echo "Invalid credentials!";
    }
}

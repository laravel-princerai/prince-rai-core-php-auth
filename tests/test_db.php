<?php

require __DIR__ . '/../vendor/autoload.php';


use CoreAuth\Database;

$db = new Database();
$conn = $db->getConnection();

if ($conn) {
    echo "✅ Database connection successful!";
} else {
    echo "❌ Failed to connect!";
}

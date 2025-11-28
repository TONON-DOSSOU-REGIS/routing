<?php

// Direct database connection script to update id_number empty strings to null without using Laravel facades

$host = '127.0.0.1';
$db   = 'your_database_name';  // <-- Replace with your actual DB name
$user = 'your_db_user';        // <-- Replace with your DB username
$pass = 'your_db_password';    // <-- Replace with your DB password
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);

    $stmt = $pdo->prepare("UPDATE users SET id_number = NULL WHERE id_number = ''");
    $stmt->execute();

    echo "Updated empty id_number values to null successfully.\n";
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
    exit(1);
}


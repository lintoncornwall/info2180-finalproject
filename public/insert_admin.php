<?php
require 'db_connection.php';

$password = password_hash("password123", PASSWORD_DEFAULT);

$sql = "INSERT INTO Users (firstname, lastname, password, email, role)
        VALUES (:firstname, :lastname, :password, :email, :role)";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':firstname' => 'Admin',
    ':lastname'  => 'User',
    ':password'  => $password,
    ':email'     => 'admin@project2.com',
    ':role'      => 'Admin'
]);

echo "Admin user created successfully.";
 

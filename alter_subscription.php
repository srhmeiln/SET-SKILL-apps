<?php
require 'config.php';

// Menambahkan kolom subscription_status dan payment_proof
$sql = "ALTER TABLE users 
        ADD COLUMN subscription_status ENUM('pending', 'waiting_verification', 'paid') DEFAULT 'pending' AFTER role,
        ADD COLUMN payment_proof VARCHAR(255) NULL AFTER subscription_status";

if ($conn->query($sql) === TRUE) {
    echo "Columns subscription_status and payment_proof added successfully.\n";
} else {
    echo "Error adding columns (they might already exist): " . $conn->error . "\n";
}

// Untuk admin yang sudah ada, set status menjadi paid otomatis agar mereka tidak perlu berlangganan
$sql_admin = "UPDATE users SET subscription_status = 'paid' WHERE role = 'admin'";
$conn->query($sql_admin);

echo "Admin accounts set to paid.\n";
?>

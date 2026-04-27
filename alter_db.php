<?php
require 'config.php';

$sql1 = "ALTER TABLE users ADD COLUMN profile_picture VARCHAR(255) NULL AFTER bio";
$sql2 = "ALTER TABLE users ADD COLUMN gender ENUM('Laki-laki', 'Perempuan', 'Lainnya') NULL AFTER profile_picture";

if ($conn->query($sql1) === TRUE) {
    echo "Added profile_picture column.\n";
} else {
    echo "profile_picture may already exist: " . $conn->error . "\n";
}

if ($conn->query($sql2) === TRUE) {
    echo "Added gender column.\n";
} else {
    echo "gender may already exist: " . $conn->error . "\n";
}
?>

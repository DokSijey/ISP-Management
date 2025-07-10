<?php

// Load CodeIgniter database configuration
require_once '../app/Config/Database.php';
use Config\Database;

// Establish a connection to the database
$db = Database::connect();

// Define the areas and their corresponding passwords
$areas = [
    'Hagonoy' => 'Hagonoy@Allstar123',
    'Malolos' => 'Malolos@Allstar123',
    'Paombong' => 'Paombong@Allstar123',
    'Bataan' => 'Bataan@Allstar123',
    'Pampanga' => 'Pampanga@Allstar123'
];

foreach ($areas as $area => $password) {
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if the area already exists in the table
    $query = $db->query("SELECT id FROM admins WHERE area = ?", [$area]);
    $exists = $query->getRow();

    if ($exists) {
        // Update existing entry
        $db->query("UPDATE admins SET password = ? WHERE area = ?", [$hashedPassword, $area]);
        echo "Updated password for: $area <br>";
    } else {
        // Insert new entry
        $db->query("INSERT INTO admins (area, password) VALUES (?, ?)", [$area, $hashedPassword]);
        echo "Inserted new admin for: $area <br>";
    }
}

echo "Password hashing complete!";

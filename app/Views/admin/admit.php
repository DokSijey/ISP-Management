<?php
require '../config.php'; // Ensure this connects to the database

header('Content-Type: application/json'); // Set response type

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $appId = $_POST["application_id"] ?? null;

    if (!$appId) {
        echo json_encode(["status" => "error", "message" => "Application ID is required"]);
        exit;
    }

    // Check if application exists
    $checkQuery = "SELECT * FROM applications WHERE id = ?";
    $stmtCheck = $conn->prepare($checkQuery);
    $stmtCheck->bind_param("i", $appId);
    $stmtCheck->execute();
    $result = $stmtCheck->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(["status" => "error", "message" => "Application not found"]);
        exit;
    }

    // Fetch application data
    $application = $result->fetch_assoc();

    // Insert data into admitted_applications table
    $insertQuery = "INSERT INTO admitted_applications (first_name, last_name, contact_number1, plan) VALUES (?, ?, ?, ?)";
    $stmtInsert = $conn->prepare($insertQuery);
    $stmtInsert->bind_param("ssss", $application['first_name'], $application['last_name'], $application['contact_number1'], $application['plan']);

    if ($stmtInsert->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Database error: " . $conn->error]);
    }
    exit;
}
?>

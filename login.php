<?php
session_start();
require_once "connection.php"; // Ensure this file contains a valid PDO connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $event_category = $_POST["event-category"]; // Dropdown selection

    if (empty($username) || empty($password)) {
        die("Please fill in all fields.");
    }

    try {
        $pdo = new PDO($dsn, $db_username, $db_password, $options); // Ensure connection is valid

        // Convert input username to lowercase & remove extra spaces
        $username = strtolower(str_replace(' ', '', $username));

        if ($event_category == "class-event") {
            $query = "SELECT * FROM classregistration WHERE REPLACE(LOWER(username), ' ', '') = :username AND password = :password";
        } elseif ($event_category == "department-event") {
            $query = "SELECT * FROM departmentregistration WHERE REPLACE(LOWER(username), ' ', '') = :username AND password = :password";
        } else {
            die("Invalid event category.");
        }

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->bindParam(":password", $password, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            die("Invalid credentials or not registered in this category.");
        }

        $_SESSION["username"] = $username;
        $_SESSION["event_category"] = $event_category;

        // Define Google Form links
        $classEventForm = "https://docs.google.com/forms/d/e/YOUR_CLASS_FORM_ID/viewform"; // Replace with actual link
        $departmentEventForm = "https://docs.google.com/forms/d/e/YOUR_DEPARTMENT_FORM_ID/viewform"; // Replace with actual link

        // Redirect based on event type
        if ($event_category == "class-event") {
            header("Location: $classEventForm");
        } elseif ($event_category == "department-event") {
            header("Location: $departmentEventForm");
        }
        exit();
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
} else {
    die("Invalid request.");
}
?>

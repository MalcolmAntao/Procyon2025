<?php
session_start();
require_once "connection.php"; // Ensure you have a valid PDO connection in this file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $event_category = $_POST["event-category"]; // Dropdown selection

    if (empty($username) || empty($password)) {
        die("Please fill in all fields.");
    }

    try {
        $pdo = new PDO($dsn, $db_username, $db_password, $options); // Ensure connection is valid
        
        // Convert input username to lowercase
        $username = strtolower($username);

        if ($event_category == "class-event") {
            $query = "SELECT * FROM classregistration WHERE LOWER(username) = :username";
        } elseif ($event_category == "department-event") {
            $query = "SELECT * FROM departmentregistration WHERE LOWER(username) = :username";
        } else {
            die("Invalid event category.");
        }

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            die("You have already registered for this event and cannot submit again.");
        }

        // Insert the new user entry (Prevent duplicate form submission)
        if ($event_category == "class-event") {
            $insertQuery = "INSERT INTO classregistration (username, password, category) VALUES (:username, :password, 'class')";
        } elseif ($event_category == "department-event") {
            $insertQuery = "INSERT INTO departmentregistration (username, password, category) VALUES (:username, :password, 'department')";
        }

        $insertStmt = $pdo->prepare($insertQuery);
        $insertStmt->bindParam(":username", $username, PDO::PARAM_STR);
        $insertStmt->bindParam(":password", $password, PDO::PARAM_STR);
        $insertStmt->execute();

        $_SESSION["username"] = $username;
        $_SESSION["event_category"] = $event_category;

        // Redirect based on event type (Replace with actual links)
        if ($event_category == "class-event") {
            header("Location: class_event_page.php"); // Replace with actual class event page link
        } elseif ($event_category == "department-event") {
            header("Location: department_event_page.php"); // Replace with actual department event page link
        }
        exit();
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
} else {
    die("Invalid request.");
}
?>

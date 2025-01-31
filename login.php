<?php
session_start();
require_once "connection.php"; // Ensure this contains a valid PDO connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $event_category = $_POST["event-category"]; // Dropdown selection

    if (empty($username) || empty($password)) {
        echo "Please fill in all fields.";
        exit();
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
            echo "Invalid event category.";
            exit();
        }

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->bindParam(":password", $password, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            echo "Invalid credentials or not registered in this category.";
            exit();
        }

        $_SESSION["username"] = $username;
        $_SESSION["event_category"] = $event_category;

        // Define Google Form links
        $classEventForm = "https://docs.google.com/forms/d/e/YOUR_CLASS_FORM_ID/viewform"; // Replace with actual link
        $departmentEventForm = "https://docs.google.com/forms/d/e/YOUR_DEPARTMENT_FORM_ID/viewform"; // Replace with actual link

        // Redirect based on event type
        if ($event_category == "class-event") {
            echo "<script>window.location.href = '$classEventForm';</script>";
        } elseif ($event_category == "department-event") {
            echo "<script>window.location.href = '$departmentEventForm';</script>";
        }
        exit();
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}
?>

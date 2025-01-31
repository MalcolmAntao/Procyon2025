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
        // Assuming the connection parameters are in connection.php
        $pdo = new PDO($dsn, $db_username, $db_password, $options); // Ensure connection is valid

        // Convert input username to lowercase & remove extra spaces
        $username = strtolower(str_replace(' ', '', $username));

        // Check the event category and prepare the query accordingly
        if ($event_category == "class-event") {
            $query = "SELECT * FROM classregistration WHERE REPLACE(LOWER(username), ' ', '') = :username AND password = :password";
        } elseif ($event_category == "department-event") {
            $query = "SELECT * FROM departmentregistration WHERE REPLACE(LOWER(username), ' ', '') = :username AND password = :password";
        } else {
            echo "Invalid event category.";
            exit();
        }

        // Prepare and execute the query
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->bindParam(":password", $password, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            echo "Invalid credentials or not registered in this category.";
            exit();
        }

        // Store session variables
        $_SESSION["username"] = $username;
        $_SESSION["event_category"] = $event_category;

        // Define Google Form links
        $classEventForm = "https://forms.gle/9Q9Lg4a4E3dYNK8bA"; // Replace with actual link for class event
        $departmentEventForm = "https://forms.gle/9Q9Lg4a4E3dYNK8bA"; // Replace with actual link for department event

        // Redirect to the appropriate Google Form based on event type
        if ($event_category == "class-event") {
            header("Location: $classEventForm"); // Redirect to class form
            exit();
        } elseif ($event_category == "department-event") {
            header("Location: $departmentEventForm"); // Redirect to department form
            exit();
        }
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}
?>

<?php
// Start or resume a session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the session timeout is reached
$session_expiration = 2 * 60; // 2 minutes in seconds
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $session_expiration)) {
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session
    header("Location: login.php"); // Redirect to the login page
    exit;
}
$_SESSION['LAST_ACTIVITY'] = time(); // Update last activity timestamp

// Establish database connection
$con = mysqli_connect(hostname: 'localhost', username: 'dbcegoaa_procyon', password: '321#Procyon', database: 'procyon2025') 
    or die("Could not connect to MySQL: " . mysqli_error(mysql: $con));

if (isset($_POST['username'])) { // Checking for 'username' key
    $user_name = str_replace(search: ' ', replace: '', subject: $_POST['username']); // Remove spaces from username
    $user_pass = $_POST['password'];
    $category = $_POST['event-category']; // Updated to match 'event-category'

    if ($category == 'class-event') {
        $stmt = $con->prepare(query: "SELECT password FROM classregistration WHERE username=? AND category='class'");
    } elseif ($category == 'department-event') {
        $stmt = $con->prepare(query: "SELECT password FROM departmentregistration WHERE username=? AND category='department'");
    } else {
        displayError(); // Invalid category
    }

    $stmt->bind_param(types: "s", var: $user_name);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify(password: $user_pass, hash: $row['password'])) {
            $_SESSION['username'] = $user_name;
            $_SESSION['event'] = ($category == 'class-event') ? 'class' : 'department';
            $_SESSION['registered_once'] = true;

            // Redirect user based on event type
            $form_url = ($_SESSION['event'] == 'class') ? 'https://forms.gle/NLUcvgoTzEXmDW9ZA' : 'https://forms.gle/acZvy37TQiKSRzAB7';

            echo "<script>
                    if (confirm('You will be allowed to register only once. Are you sure to register now?')) {
                        window.location.href = '$form_url';
                    } else {
                        window.location.href = './index.php#mu-register';
                    }
                  </script>";
            exit;
        } else {
            displayError(); // Wrong password
        }
    } else {
        displayError(); // User not found
    }
}

function displayError(): never
{
    echo "<script>alert('Email, password, or category is incorrect!');</script>";
    echo "<script>window.location.href='./index.php#mu-register';</script>";
    exit;
}
?>

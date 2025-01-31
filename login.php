<?php
// Start or resume a session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Set session expiration (5 minutes = 300 seconds)
$session_expiration = 5 * 60; // 5 minutes in seconds

// Check if session has timed out
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $session_expiration)) {
    // Session expired, destroy session and redirect to login page
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session
    header("Location: login.php"); // Redirect to login page
    exit;
}
$_SESSION['LAST_ACTIVITY'] = time(); // Update last activity timestamp

// Establish database connection
$con = mysqli_connect('localhost', 'dbcegoaa_procyon', '321#Procyon', 'dbcegoaa_procyon2024') or die("Could not connect to mysql" . mysqli_error($con));

if (isset($_POST['login'])) {
    $user_name = $_POST['username'];
    $user_pass = $_POST['password'];
    $category = $_POST['event-category'];

    // Prevent SQL injection using prepared statements
    if ($category == 'class-event') {
        $stmt = $con->prepare("SELECT * FROM crregistration WHERE username=? AND password=? AND category='class'");
        $stmt->bind_param("ss", $user_name, $user_pass);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $_SESSION['username'] = $user_name;
            $_SESSION['event'] = 'class';
            $_SESSION['registered_once'] = true; // Flag to indicate registration
        } else {
            // Invalid login credentials
            displayError();
        }
    } elseif ($category == 'department-event') {
        $stmt = $con->prepare("SELECT * FROM deptregistrations WHERE username=? AND password=? AND category='department'");
        $stmt->bind_param("ss", $user_name, $user_pass);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $_SESSION['username'] = $user_name;
            $_SESSION['event'] = 'department';
            $_SESSION['registered_once'] = true; // Flag to indicate registration
        } else {
            // Invalid login credentials
            displayError();
        }
    } else {
        // No category selected
        displayError();
    }

    // Redirect based on event type
    if ($_SESSION['event'] == 'class') {
        if ($_SESSION['registered_once']) {
            echo "<script>
                    if(confirm('You will be allowed to register only once. Are you sure to register now?')) {
                        window.location.href = 'https://forms.gle/NLUcvgoTzEXmDW9ZA';
                    } else {
                        window.location.href = './index.php#mu-register';
                    }
                  </script>";
            exit;
        } else {
            header("Location: ./index.php#mu-register");
            exit;
        }
    } elseif ($_SESSION['event'] == 'department') {
        if ($_SESSION['registered_once']) {
            echo "<script>
                    if(confirm('You will be allowed to register only once. Are you sure to register now?')) {
                        window.location.href = 'https://forms.gle/acZvy37TQiKSRzAB7';
                    } else {
                        window.location.href = './index.php#mu-register';
                    }
                  </script>";
            exit;
        } else {
            header("Location: ./index.php#mu-register");
            exit;
        }
    }
}

// Function to display error message
function displayError()
{
    echo "<script>alert('Email or password or choice is incorrect!')</script>";
    echo "<script>window.location.href='./index.php#mu-register';</script>";
    exit;
}
?>

<?php
// Enable error reporting for debugging purposes
error_reporting(E_ALL);
ini_set('display_errors', 1);

$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['usrnam_name'];
    $email = $_POST['mail_name'];
    $number = $_POST['contct_name'];
    $password = $_POST['pass_name'];
    $confirm_password = $_POST['cpass_name'];

    // Validate form data
    if (empty($name) || empty($email) || empty($number) || empty($password) || empty($confirm_password)) {
        $errors[] = "Please fill in all fields.";
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // Validate contact number format
    if (!preg_match("/^[0-9]{12}$/", $number)) {
        $errors[] = "Invalid contact number format. Please enter a 12-digit number.";
    }

    // Validate password length
    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    // If there are no errors, proceed with database insertion
    if (empty($errors)) {
        // Prepend "92" to the contact number if it's not already present
        if (substr($number, 0, 2) !== "92") {
            $number = "92" . $number;
        }

        // Connect to the database
        $db = mysqli_connect('localhost', 'root', '', 'getbus') or die("Could not connect to Database");

        // Escape special characters in input values to prevent SQL injection
        $name = mysqli_real_escape_string($db, $name);
        $email = mysqli_real_escape_string($db, $email);
        $password = mysqli_real_escape_string($db, $password);
        $number = mysqli_real_escape_string($db, $number);

        // Insert user details into the database
        $query = "INSERT INTO users (name, email, password, contact_number) VALUES ('$name', '$email', '$password', '$number')";

        $result = mysqli_query($db, $query);

        // Check if the query was executed successfully
        if ($result) {
            // Close database connection
            mysqli_close($db);

            // Redirect to the login page after successful insertion
            header('Location: login.html');
            exit(); // Terminate script execution after redirection
        } else {
            // If an error occurred during insertion, display an error message
            $errors[] = "Error: " . mysqli_error($db);
            // Close database connection
            mysqli_close($db);
        }
    }
}

// Return errors to the signup.html file
echo json_encode($errors);

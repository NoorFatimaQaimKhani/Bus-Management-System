<?php
session_start(); // Start session for user authentication

// Function to authenticate user and store user information in session variables
function authenticateUser($email, $password)
{
    // Establish a database connection
    $db = mysqli_connect('localhost', 'root', '', 'getbus') or die("Could not connect to Database");

    // Prepare SQL query to fetch user details based on email and password
    $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($db, $query) or die("Could not execute query");

    // Check if the query returned any rows
    if (mysqli_num_rows($result) == 1) {
        // Fetch user details
        $user = mysqli_fetch_assoc($result);

        // Set session variables
        $_SESSION['loggedin'] = true;
        $_SESSION['email'] = $email;
        $_SESSION['user_id'] = $user['user_id']; // Assuming the column name is 'user_id'

        // Close database connection
        mysqli_close($db);

        // Set success message and redirect back to login.html page with message appended to URL
        header('Location: login.html?login_message=Login%20successful');
        exit();
    } else {
        // Close database connection
        mysqli_close($db);

        // Set error message and redirect back to login.html page with message appended to URL
        header('Location: login.html?login_message=Invalid%20email%20or%20password');
        exit();
    }
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input values from the login form
    $email = $_POST['eml'];
    $password = $_POST['pass'];

    // Call the function to authenticate user
    authenticateUser($email, $password);
}

<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Check if the user is logged in
    if (isset($_SESSION['email'])) {
        // Retrieve the email from the session
        $email = $_SESSION['email'];

        // Respond with the email as JSON
        echo json_encode(['email' => $email]);
    } else {
        // If user is not logged in, respond with an empty email
        echo json_encode(['email' => '']);
    }
}

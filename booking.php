<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $servername = "localhost";
    $username = "root"; // Replace with your MySQL username
    $password = ""; // Replace with your MySQL password
    $dbname = "getbus"; // Replace with your database name

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve form data
    $email = $_POST['email'];
    $departingCity = $_POST['departing_city'];
    $destination = $_POST['destination'];
    $departingTime = $_POST['departing_time'];
    $seat = $_POST['seat'];
    $fare = $_POST['fare'];

    // Check if the user is logged in
    if (isset($_SESSION['user_id'])) {
        // If user is logged in, retrieve their user_id
        $userId = $_SESSION['user_id'];

        // Insert data into passenger table
        $sqlPassenger = "INSERT INTO passengers (user_id) VALUES ('$userId')";
        if ($conn->query($sqlPassenger) === TRUE) {
            // Get the auto-generated passenger_id
            $passengerId = $conn->insert_id;

            // Insert data into bookings table
            $sqlBooking = "INSERT INTO bookings (passenger_id, bus_id, date_of_booking, seats_booked)
                    VALUES ('$passengerId', (SELECT bus_id FROM bus_details WHERE route_id = (SELECT route_id FROM bus_routes WHERE source = '$departingCity' AND destination = '$destination') AND departure_time = '$departingTime'), NOW(), '$seat')";

            if ($conn->query($sqlBooking) === TRUE) {
                // Redirect to receipt page with booking details
                header("Location: receipt.php?email=$email&departingCity=$departingCity&destination=$destination&departingTime=$departingTime&seat=$seat&fare=$fare");
                exit();
            } else {
                echo "Error: " . $sqlBooking . "<br>" . $conn->error;
            }
        } else {
            echo "Error: " . $sqlPassenger . "<br>" . $conn->error;
        }
    } else {
        // If user is not logged in, handle accordingly
        echo "User not logged in.";
    }

    $conn->close();
} else {
    // Handle cases where the form is not submitted
    echo "Invalid request.";
}

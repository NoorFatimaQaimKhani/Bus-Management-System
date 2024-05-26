<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "getbus"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve parameters
$departingCity = $_GET['departingCity'];
$destination = $_GET['destination'];
$departingTime = $_GET['departingTime'];
$numSeats = intval($_GET['numSeats']); // Convert the number of seats to an integer

// Query to retrieve the fare per seat for the given route and departing time
$sql = "SELECT fare FROM bus_details WHERE route_id = (SELECT route_id FROM bus_routes WHERE source = '$departingCity' AND destination = '$destination') AND departure_time = '$departingTime'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $farePerSeat = $row['fare'];

    // Calculate total fare for all seats booked
    $totalFare = $farePerSeat * $numSeats;

    echo $totalFare; // Output the total fare
} else {
    echo '0'; // If no matching record found, return 0 fare
}

$conn->close(); // Close the database connection

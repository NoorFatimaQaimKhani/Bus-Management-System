<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "getbus"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$departingCity = $_GET['departingCity'];
$destination = $_GET['destination'];

// Fetch departure times based on selected departing city and destination
$sql = "SELECT DISTINCT bd.departure_time 
        FROM bus_routes br 
        INNER JOIN bus_details bd ON br.route_id = bd.route_id 
        WHERE br.source = '$departingCity' AND br.destination = '$destination'";
$result = $conn->query($sql);

if ($result) {
    if ($result->num_rows > 0) {
        // Output departure times in a dropdown list
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['departure_time'] . '">' . $row['departure_time'] . '</option>';
        }
    } else {
        echo '<option value="">No departing times available</option>';
    }
} else {
    echo "Error: " . $conn->error; // Echo any SQL errors for debugging
}

$conn->close();

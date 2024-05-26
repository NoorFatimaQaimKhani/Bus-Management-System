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

$sql = "SELECT DISTINCT destination FROM bus_routes WHERE source = '$departingCity'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . $row['destination'] . '">' . $row['destination'] . '</option>';
    }
} else {
    echo '<option value="">No destinations available</option>';
}

$conn->close();

<?php
// Connect to the database
$mysqli = new mysqli('localhost', 'root', '', 'getbus');

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Query to fetch bus schedules and routes
$query = "SELECT bd.bus_id, bd.bus_name, bd.route_id, bd.fare, bd.departure_time, bd.status, bd.available_seats, bd.current_date, br.source, br.destination, br.route_time 
          FROM bus_details bd
          INNER JOIN bus_routes br ON bd.route_id = br.route_id";
$result = $mysqli->query($query);

$data = array();

// Fetch data
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Format departure time in AM/PM format
        $departure_time = date("h:i A", strtotime($row['departure_time']));

        // Update status based on current date and time
        $current_date = date("Y-m-d");
        $current_time = date("H:i:s");
        $departure_datetime = $current_date . " " . $row['departure_time'];
        if ($current_date >= $row['current_date'] && $current_time >= $row['departure_time']) {
            $status = "departed";
        } else {
            $status = $row['status'];
        }

        // Append formatted data to result array
        $row['departure_time'] = $departure_time;
        $row['status'] = $status;
        $data[] = $row;
    }
}

// Close database connection
$mysqli->close();

echo json_encode($data);

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
</head>

<body>
    <h2>Booking Receipt</h2>
    <p><strong>Email:</strong> <?php echo $_GET['email']; ?></p>
    <p><strong>Departing City:</strong> <?php echo $_GET['departingCity']; ?></p>
    <p><strong>Destination:</strong> <?php echo $_GET['destination']; ?></p>
    <p><strong>Departing Time:</strong> <?php echo $_GET['departingTime']; ?></p>
    <p><strong>Seat:</strong> <?php echo $_GET['seat']; ?></p>
    <p><strong>Fare:</strong> <?php echo $_GET['fare']; ?></p>
</body>

</html>
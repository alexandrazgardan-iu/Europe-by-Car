<?php

session_start();

require_once "../backend/db.php";

if (!isset($_GET['booking_id'])) {
    echo "No booking found.";
    exit;
}

$booking_id = $_GET['booking_id'];

$sql = "SELECT * FROM bookings WHERE booking_id = $booking_id";

$result = $conn->query($sql);

$booking = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Booking Confirmation - Europe by Car</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f0e8;
            padding: 40px;
        }

        .confirmation {
            max-width: 600px;
            margin: auto;
            background-color: f5f0e8;
            padding: 25px;
            border-radius: 9px;
        }

        h1 {
            color: #222;
        }

        .total {
            font-size: 23px;
            font-weight: bold;
        }

    </style>

</head>

<body>

<div class="confirmation">

    <h1>Booking Confirmed</h1>

    <p>
        Thank you for booking with Europe by Car.
    </p>

    <p>
        <strong>Booking ID:</strong>
        <?php echo $booking['booking_id']; ?>
    </p>

    <p>
        <strong>Customer:</strong>
        <?php echo $booking['customer_name']; ?>
    </p>

    <p>
        <strong>Email:</strong>
        <?php echo $booking['customer_email']; ?>
    </p>

    <p>
        <strong>Pickup Location:</strong>
        <?php echo $booking['pickup_location']; ?>
    </p>

    <p>
        <strong>Return Location:</strong>
        <?php echo $booking['return_location']; ?>
    </p>

    <p>
        <strong>Pickup Date:</strong>
        <?php echo $booking['pickup_date']; ?>
    </p>

    <p>
        <strong>Return Date:</strong>
        <?php echo $booking['return_date']; ?>
    </p>

    <p class="total">
        Total Price: €<?php echo $booking['total_price']; ?>
    </p>

</div>

</body>

</html>
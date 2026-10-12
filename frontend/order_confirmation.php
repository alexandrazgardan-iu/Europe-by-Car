<?php

session_start();

require_once "../backend/db.php";

if (!isset($_GET['booking_id'])) {
    echo "No booking found.";
    exit;
}


$booking_id = filter_input(INPUT_GET, 'booking_id', FILTER_VALIDATE_INT);

if (!$booking_id || $booking_id < 1) {
    http_response_code(400);
    exit("Invalid booking ID.");
}

$stmt = $conn->prepare(
    "SELECT * FROM bookings WHERE booking_id = ?"
);

$stmt->bind_param("i", $booking_id);
$stmt->execute();

$result = $stmt->get_result();
$booking = $result->fetch_assoc();

if (!$booking) {
    http_response_code(404);
    exit("Booking not found.");
}

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
    color: #3d342b;
    padding: 40px 20px;
    margin: 0;
}

.confirmation {
    max-width: 600px;
    margin: 40px auto;
    background-color: #ffffff;
    padding: 30px;
    border: 1px solid #e5ddd3;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
}

h1 {
    color: #70543e;
    text-align: center;
    margin-top: 0;
}

.total {
    font-size: 23px;
    font-weight: bold;
    color: #70543e;
    border-top: 1px solid #e5ddd3;
    padding-top: 18px;
    margin-top: 24px;
}

.confirmation p {
    line-height: 1.6;
}

@media (max-width: 600px) {
    body {
        padding: 15px;
    }

    .confirmation {
        padding: 20px;
        margin: 20px auto;
    }
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
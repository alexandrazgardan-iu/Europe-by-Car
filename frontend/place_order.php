<?php

session_start();

require_once "../backend/db.php";

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    die("Your cart is empty.");
}

$customer_name = $_POST['customer_name'];
$customer_email = $_POST['customer_email'];
$pickup_location = $_POST['pickup_location'];
$return_location = $_POST['return_location'];
$pickup_date = $_POST['pickup_date'];
$return_date = $_POST['return_date'];

$start = new DateTime($pickup_date);
$end = new DateTime($return_date);

$number_of_days = $start->diff($end)->days;

if ($number_of_days < 1) {
    $number_of_days = 1;
}

$total_price = 0;


// Calculate total price

foreach ($_SESSION['cart'] as $vehicle_id => $quantity) {

    $stmt = $conn->prepare(
        "SELECT price_per_day FROM vehicles WHERE vehicle_id = ?"
    );

    $stmt->bind_param("i", $vehicle_id);

    $stmt->execute();

    $result = $stmt->get_result();

    $vehicle = $result->fetch_assoc();

    $price_per_day = $vehicle['price_per_day'];

    $subtotal = $price_per_day * $number_of_days * $quantity;

    $total_price = $total_price + $subtotal;
}


// Save booking

$stmt = $conn->prepare(
    "INSERT INTO bookings
    (customer_name, customer_email, pickup_location, return_location,
    pickup_date, return_date, total_price, status)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
);

$status = "confirmed";

$stmt->bind_param(
    "ssssssds",
    $customer_name,
    $customer_email,
    $pickup_location,
    $return_location,
    $pickup_date,
    $return_date,
    $total_price,
    $status
);

$stmt->execute();

$booking_id = $conn->insert_id;


// Save booking items

foreach ($_SESSION['cart'] as $vehicle_id => $quantity) {

    $stmt = $conn->prepare(
        "SELECT price_per_day
        FROM vehicles
        WHERE vehicle_id = ?"
    );

    $stmt->bind_param("i", $vehicle_id);

    $stmt->execute();

    $result = $stmt->get_result();

    $vehicle = $result->fetch_assoc();

    $price_per_day = $vehicle['price_per_day'];

    $subtotal = $price_per_day * $number_of_days * $quantity;


    $stmt = $conn->prepare(
        "INSERT INTO booking_items
        (booking_id, vehicle_id, price_per_day, number_of_days, subtotal)
        VALUES (?, ?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "iidid",
        $booking_id,
        $vehicle_id,
        $price_per_day,
        $number_of_days,
        $subtotal
    );

    $stmt->execute();
}


// Redirect to confirmation page

header(
    "Location: order_confirmation.php?booking_id=" . $booking_id
);

exit;

?>
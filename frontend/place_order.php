
<?php

session_start();

require_once "../backend/db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit("Invalid request method.");
}

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    exit("Your cart is empty.");
}

// Get customer and booking information
$customer_name = trim($_POST['customer_name'] ?? '');
$customer_email = trim($_POST['customer_email'] ?? '');
$pickup_location = trim($_POST['pickup_location'] ?? '');
$return_location = trim($_POST['return_location'] ?? '');
$pickup_date = $_POST['pickup_date'] ?? '';
$return_date = $_POST['return_date'] ?? '';

// Validate required fields
if (
    $customer_name === '' ||
    $customer_email === '' ||
    $pickup_location === '' ||
    $return_location === '' ||
    $pickup_date === '' ||
    $return_date === ''
) {
    exit("Please complete all required fields.");
}

if (!filter_var($customer_email, FILTER_VALIDATE_EMAIL)) {
    exit("Please enter a valid email address.");
}

// Validate dates
$start = DateTime::createFromFormat('!Y-m-d', $pickup_date);
$end = DateTime::createFromFormat('!Y-m-d', $return_date);

if (
    !$start ||
    !$end ||
    $start->format('Y-m-d') !== $pickup_date ||
    $end->format('Y-m-d') !== $return_date
) {
    exit("Please enter valid pickup and return dates.");
}

$today = new DateTime('today');

if ($start < $today) {
    exit("Pickup date cannot be in the past.");
}

if ($end <= $start) {
    exit("Return date must be after the pickup date.");
}

$number_of_days = $start->diff($end)->days;
$total_price = 0;

try {
    $conn->begin_transaction();

    // Calculate total price and validate cart items
    foreach ($_SESSION['cart'] as $vehicle_id => $quantity) {
        $vehicle_id = filter_var($vehicle_id, FILTER_VALIDATE_INT);
        $quantity = filter_var($quantity, FILTER_VALIDATE_INT);

        if (!$vehicle_id || $vehicle_id < 1 || !$quantity || $quantity < 1) {
            throw new Exception("Invalid vehicle or quantity in cart.");
        }

        $stmt = $conn->prepare(
            "SELECT price_per_day FROM vehicles WHERE vehicle_id = ?"
        );

        $stmt->bind_param("i", $vehicle_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $vehicle = $result->fetch_assoc();

        if (!$vehicle) {
            throw new Exception("A selected vehicle could not be found.");
        }

        $price_per_day = (float) $vehicle['price_per_day'];
        $total_price += $price_per_day * $number_of_days * $quantity;
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
        $vehicle_id = (int) $vehicle_id;
        $quantity = (int) $quantity;

        $stmt = $conn->prepare(
            "SELECT price_per_day FROM vehicles WHERE vehicle_id = ?"
        );

        $stmt->bind_param("i", $vehicle_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $vehicle = $result->fetch_assoc();

        if (!$vehicle) {
            throw new Exception("A selected vehicle could not be found.");
        }

        $price_per_day = (float) $vehicle['price_per_day'];
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

    // Save all changes together
    $conn->commit();

    // Clear cart only after successful booking
    $_SESSION['cart'] = [];

    header(
        "Location: order_confirmation.php?booking_id=" . $booking_id
    );
    exit;

} catch (Throwable $e) {
    $conn->rollback();

    error_log("Booking error: " . $e->getMessage());

    http_response_code(500);
    echo "We could not complete your booking. Your cart has been preserved. Please try again.";
    exit;
}

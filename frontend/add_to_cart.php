<?php

session_start();

require_once "../backend/db.php";

$vehicle_id = $_POST['vehicle_id'] ?? 0;

$vehicle_id = (int) $vehicle_id;

$stmt = $conn->prepare(
    "SELECT vehicle_id FROM vehicles WHERE vehicle_id = ?"
);

$stmt->bind_param("i", $vehicle_id);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 0) {

    echo json_encode([
        "success" => false,
        "message" => "Vehicle not found."
    ]);

    exit;
}


if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_SESSION['cart'][$vehicle_id])) {

    $_SESSION['cart'][$vehicle_id]++;

} else {

    $_SESSION['cart'][$vehicle_id] = 1;
}


$cart_count = array_sum($_SESSION['cart']);


echo json_encode([
    "success" => true,
    "cart_count" => $cart_count
]);

?>
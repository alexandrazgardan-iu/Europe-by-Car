<?php

session_start();

$vehicle_id = $_GET['id'];

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_SESSION['cart'][$vehicle_id])) {

    $_SESSION['cart'][$vehicle_id]++;

} else {

    $_SESSION['cart'][$vehicle_id] = 1;

}

echo "Vehicle added to cart.";

?>
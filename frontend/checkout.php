<?php

session_start();

require_once "../backend/db.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Checkout - Europe by Car</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f5f0e8;
        }

        .checkout-container {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background-color: white;
            border-radius: 12px;
        }

        .checkout-container h2 {
            margin-top: 0;
            font-size: 32px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input {
            width: 100%;
            box-sizing: border-box;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .confirm-button {
            width: 100%;
            margin-top: 10px;
            padding: 15px;
            border: none;
            border-radius: 6px;
            background-color: #222;
            color: white;
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
        }

        .confirm-button:hover {
            background-color: #a58f78;
        }

    </style>

</head>

<body>

<?php include "header.php"; ?>

<div class="checkout-container">

    <h2>Checkout</h2>

    <form action="place_order.php" method="POST">

        <div class="form-group">

            <label>Customer Name:</label>

            <input
                type="text"
                name="customer_name"
                required
            >

        </div>


        <div class="form-group">

            <label>Customer Email:</label>

            <input
                type="email"
                name="customer_email"
                required
            >

        </div>


        <div class="form-group">

            <label>Pickup Location:</label>

            <input
                type="text"
                name="pickup_location"
                required
            >

        </div>


        <div class="form-group">

            <label>Return Location:</label>

            <input
                type="text"
                name="return_location"
                required
            >

        </div>


        <div class="form-group">

            <label>Pickup Date:</label>

            <input
                type="date"
                name="pickup_date"
                required
            >

        </div>


        <div class="form-group">

            <label>Return Date:</label>

            <input
                type="date"
                name="return_date"
                required
            >

        </div>


        <button type="submit" class="confirm-button">
            Confirm Booking
        </button>

    </form>

</div>

</body>

</html>
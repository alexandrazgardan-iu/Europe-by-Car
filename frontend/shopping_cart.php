<?php

session_start();

require_once "../backend/db.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Shopping Cart - Europe by Car</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #d8c8b5;
        }

        .cart-container {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
        }

        .cart-item {
            background-color: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
        }

        .cart-item h2 {
            margin-top: 0;
        }

        .total {
            background-color: #d8c8b5;
            padding: 20px;
            border-radius: 10px;
            font-size: 21px;
            font-weight: bold;
            margin-top: 20px;
        }

       .checkout-button {
    display: block;
    width: 100%;
    box-sizing: border-box;
    margin-top: 30px;
    padding: 18px 0;
    border-top: 2px solid #222;
    color: #222;
text-decoration: underline;
    text-decoration: none;
    font-size: 30px;
    font-weight: 700;
}

    </style>

</head>

<body>

<?php include "header.php"; ?>


<div class="cart-container">

    <h2>Shopping Cart</h2>

    <?php

    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {

        echo "<p>Your cart is empty.</p>";

    } else {

        $total = 0;

        foreach ($_SESSION['cart'] as $vehicle_id => $quantity) {

            $sql = "SELECT * FROM vehicles WHERE vehicle_id = $vehicle_id";

            $result = $conn->query($sql);

            $vehicle = $result->fetch_assoc();

            $subtotal = $vehicle['price_per_day'] * $quantity;

            $total = $total + $subtotal;

    ?>

            <div class="cart-item">

                <h2>
                    <?php echo $vehicle['brand']; ?>
                    <?php echo $vehicle['model']; ?>
                </h2>

                <p>
                    <strong>Category:</strong>
                    <?php echo $vehicle['category']; ?>
                </p>

                <p>
                    <strong>Price:</strong>
                    €<?php echo $vehicle['price_per_day']; ?> / day
                </p>

                <p>
                    <strong>Quantity:</strong>
                    <?php echo $quantity; ?>
                </p>

                <p>
                    <strong>Subtotal:</strong>
                    €<?php echo $subtotal; ?>
                </p>

            </div>

    <?php

        }

    ?>

        <div class="total">

            Total: €<?php echo $total; ?>

        </div>

        <a class="checkout-button" href="checkout.php">
            Proceed to Checkout
        </a>

    <?php

    }

    ?>

</div>

</body>

</html>
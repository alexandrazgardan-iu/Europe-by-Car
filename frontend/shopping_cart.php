<?php

session_start();

require_once "../backend/db.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
>
    <title>Shopping Cart - Europe by Car</title>

 <style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0 20px 30px;
    background-color: #f5f0e8;
    color: #3d342b;
}

.cart-container {
    max-width: 900px;
    margin: 40px auto;
    padding: 24px;
}

.cart-container > h2 {
    text-align: center;
    margin-bottom: 30px;
    color: #3d342b;
}

.cart-item {
    background-color: #ffffff;
    padding: 24px;
    margin-bottom: 20px;
    border: 1px solid #e5ddd3;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

.cart-item h2 {
    margin-top: 0;
    color: #70543e;
}

.total {
    background-color: #ffffff;
    border: 1px solid #e5ddd3;
    padding: 20px;
    border-radius: 12px;
    font-size: 21px;
    font-weight: bold;
    margin-top: 24px;
}

.checkout-button {
    display: block;
    width: 100%;
    box-sizing: border-box;
    margin-top: 24px;
    padding: 16px;
    background-color: #70543e;
    border-radius: 8px;
    color: #ffffff;
    text-align: center;
    text-decoration: none;
    font-size: 18px;
    font-weight: 700;
}

.checkout-button:hover {
    background-color: #3d342b;
    color: #ffffff;
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
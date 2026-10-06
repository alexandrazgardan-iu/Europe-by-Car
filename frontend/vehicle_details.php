<?php

require_once "../backend/db.php";

$vehicle_id = $_GET['id'];

$stmt = $conn->prepare(
    "SELECT * FROM vehicles WHERE vehicle_id = ?"
);

$stmt->bind_param("i", $vehicle_id);

$stmt->execute();

$result = $stmt->get_result();

$vehicle = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Vehicle Details - Europe by Car</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background-color: #f5f5f5;
        }

        .vehicle-details {
            max-width: 600px;
            margin: 30px auto;
            background-color: white;
            padding: 25px;
            border-radius: 10px;
        }

        .vehicle-details img {
            width: 100%;
            max-height: 300px;
            object-fit: cover;
            border-radius: 8px;
        }

        .price {
            font-size: 22px;
            font-weight: bold;
        }

        button {
            padding: 12px 20px;
            cursor: pointer;
        }

    </style>

</head>

<body>

<?php include "header.php"; ?>

<div class="vehicle-details">

    <img
        src="../assets/<?php echo $vehicle['image']; ?>"
        alt="<?php echo $vehicle['brand'] . ' ' . $vehicle['model']; ?>"
    >

    <h2>
        <?php echo $vehicle['brand']; ?>
        <?php echo $vehicle['model']; ?>
    </h2>

    <p>
        <strong>Category:</strong>
        <?php echo $vehicle['category']; ?>
    </p>

    <p>
        <strong>Fuel:</strong>
        <?php echo $vehicle['fuel_type']; ?>
    </p>

    <p>
        <strong>Transmission:</strong>
        <?php echo $vehicle['transmission']; ?>
    </p>

    <p>
        <strong>Seats:</strong>
        <?php echo $vehicle['seats']; ?>
    </p>

    <p>
        <strong>Doors:</strong>
        <?php echo $vehicle['doors']; ?>
    </p>

    <p>
        <?php echo $vehicle['description']; ?>
    </p>

    <p class="price">
        €<?php echo $vehicle['price_per_day']; ?> / day
    </p>

    <button type="button" id="addToCartButton">
        Add to Cart
    </button>

    <p id="cartMessage"></p>

</div>


<script>

document.getElementById("addToCartButton").addEventListener("click", function() {

    const vehicleId = <?php echo $vehicle['vehicle_id']; ?>;

    fetch("add_to_cart.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "vehicle_id=" + vehicleId
    })

    .then(response => response.json())

    .then(data => {

        if (data.success) {

            document.getElementById("cartMessage").textContent =
                "Vehicle added to cart.";

            document.getElementById("cartCount").textContent =
                data.cart_count;

        }

    });

});

</script>

</body>

</html>




<?php

require_once "../backend/db.php";

$sql = "SELECT * FROM vehicles";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Europe by Car</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background-color: #f5f0e8;
        }

        h1 {
            text-align: center;
        }

        .catalog {
            display: flex;
            flex-wrap: wrap;
            gap: 25px;
        }

        .vehicle-card {
            width: 250px;
            padding: 20px;
            background-color: a58f78;
            }

            
        .vehicle-card img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 8px;
        }

        .price {
            font-weight: bold;
        }

    </style>

</head>

<body>

<?php include "header.php"; ?>

<h2>Vehicle Catalog</h2>
<div class="catalog">

<?php while ($vehicle = $result->fetch_assoc()): ?>

    <div class="vehicle-card">

        <img 
            src="../assets/<?php echo $vehicle['image']; ?>"
            alt="<?php echo $vehicle['brand'] . ' ' . $vehicle['model']; ?>"
        >

        <h3>
            <?php echo $vehicle['brand']; ?>
            <?php echo $vehicle['model']; ?>
        </h3>

        <p>
            Category: <?php echo $vehicle['category']; ?>
        </p>

        <p>
            Fuel: <?php echo $vehicle['fuel_type']; ?>
        </p>

        <p>
            Transmission: <?php echo $vehicle['transmission']; ?>
        </p>

        <p>
            Seats: <?php echo $vehicle['seats']; ?>
        </p>

        <p>
            <?php echo $vehicle['description']; ?>
        </p>

        <p class="price">
            €<?php echo $vehicle['price_per_day']; ?> / day
        </p>

<a href="vehicle_details.php?id=<?php echo $vehicle['vehicle_id']; ?>">
    View Details
</a>
    </div>

<?php endwhile; ?>

</div>

</body>

</html>

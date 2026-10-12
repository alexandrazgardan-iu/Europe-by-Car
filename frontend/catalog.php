
<?php

require_once "../backend/db.php";

$search = trim($_GET['search'] ?? '');
$category = trim($_GET['category'] ?? '');
$fuel = trim($_GET['fuel'] ?? '');

$sql = "SELECT * FROM vehicles WHERE 1=1";
$params = [];
$types = "";

if ($search !== '') {
    $sql .= " AND (brand LIKE ? OR model LIKE ?)";
    $term = "%" . $search . "%";
    $params[] = $term;
    $params[] = $term;
    $types .= "ss";
}

if ($category !== '') {
    $sql .= " AND category = ?";
    $params[] = $category;
    $types .= "s";
}

if ($fuel !== '') {
    $sql .= " AND fuel_type = ?";
    $params[] = $fuel;
    $types .= "s";
}

$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

$categoriesResult = $conn->query(
    "SELECT DISTINCT category FROM vehicles ORDER BY category"
);

$fuelResult = $conn->query(
    "SELECT DISTINCT fuel_type FROM vehicles ORDER BY fuel_type"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Europe by Car</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background-color: #f5f0e8;
        }

        h1, h2 {
            text-align: center;
            color: #3d342b;
        }

        .catalog {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
            align-items: stretch;
        }

        .vehicle-card {
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #e5ddd3;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            min-width: 0;
        }

        .vehicle-card h3 {
            margin-top: 15px;
            color: #3d342b;
        }

        .vehicle-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 8px;
        }

        .price {
            font-weight: bold;
            color: #70543e;
            font-size: 1.1rem;
        }

        @media (max-width: 600px) {
            body {
                margin: 15px;
            }

            .catalog {
                grid-template-columns: 1fr;
            }
        }

.vehicle-card {
    display: flex;
    flex-direction: column;
}

.vehicle-card .price {
    margin-top: auto;
}

.vehicle-card .btn {
    margin-top: 12px !important;
}

    </style>
</head>

<body>

<?php include "header.php"; ?>

<h2 class="mb-4">Vehicle Catalog</h2>

<form method="GET" action="catalog.php" class="row g-3 mb-4">

    <div class="col-md-4">
        <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Search by brand or model"
            value="<?php echo htmlspecialchars($search); ?>"
        >
    </div>

    <div class="col-md-3">
        <select name="category" class="form-select">
            <option value="">All categories</option>

            <?php while ($cat = $categoriesResult->fetch_assoc()): ?>
                <option
                    value="<?php echo htmlspecialchars($cat['category']); ?>"
                    <?php echo $category === $cat['category'] ? 'selected' : ''; ?>
                >
                    <?php echo htmlspecialchars($cat['category']); ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>

    <div class="col-md-3">
        <select name="fuel" class="form-select">
            <option value="">All fuel types</option>

            <?php while ($fuelType = $fuelResult->fetch_assoc()): ?>
                <option
                    value="<?php echo htmlspecialchars($fuelType['fuel_type']); ?>"
                    <?php echo $fuel === $fuelType['fuel_type'] ? 'selected' : ''; ?>
                >
                    <?php echo htmlspecialchars($fuelType['fuel_type']); ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>

    <div class="col-md-2">
        <button type="submit" class="btn btn-dark w-100">
            Search
        </button>
    </div>

</form>

<div class="catalog">

<?php while ($vehicle = $result->fetch_assoc()): ?>

    <div class="vehicle-card card h-100">

        <img
            src="../assets/<?php echo htmlspecialchars($vehicle['image']); ?>"
            alt="<?php echo htmlspecialchars($vehicle['brand'] . ' ' . $vehicle['model']); ?>"
        >

        <h3>
            <?php echo htmlspecialchars($vehicle['brand']); ?>
            <?php echo htmlspecialchars($vehicle['model']); ?>
        </h3>

        <p>
            Category: <?php echo htmlspecialchars($vehicle['category']); ?>
        </p>

        <p>
            Fuel: <?php echo htmlspecialchars($vehicle['fuel_type']); ?>
        </p>

        <p>
            Transmission: <?php echo htmlspecialchars($vehicle['transmission']); ?>
        </p>

        <p>
            Seats: <?php echo (int) $vehicle['seats']; ?>
        </p>

        <p>
            <?php echo htmlspecialchars($vehicle['description']); ?>
        </p>

        <p class="price">
            €<?php echo htmlspecialchars((string) $vehicle['price_per_day']); ?> / day
        </p>

        <a
            href="vehicle_details.php?id=<?php echo (int) $vehicle['vehicle_id']; ?>"
            class="btn btn-dark mt-2"
        >
            View Details
        </a>

    </div>

<?php endwhile; ?>

</div>

</body>
</html>

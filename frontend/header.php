<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$cart_count = 0;

if (isset($_SESSION['cart'])) {
    $cart_count = array_sum($_SESSION['cart']);
}

?>

<header>

    <h1>Europe by Car</h1>

    <nav>

        <a href="catalog.php">Vehicle Catalog</a>

        <a href="shopping_cart.php">
            🛒 Cart (<span id="cartCount"><?php echo $cart_count; ?></span>)
        </a>

    </nav>

</header>
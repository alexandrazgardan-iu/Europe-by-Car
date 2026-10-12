
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$cart_count = 0;

if (isset($_SESSION['cart'])) {
    $cart_count = array_sum($_SESSION['cart']);
}

?>

<header class="site-header">

    <div class="header-inner">

        <a href="catalog.php" class="site-logo">
            Europe by Car
        </a>

        <nav class="site-nav">

            <a href="catalog.php" class="nav-link">
                Vehicle Catalog
            </a>

            <a href="shopping_cart.php" class="nav-link cart-link">
                🛒 Cart
                <span id="cartCount" class="cart-count">
                    <?php echo $cart_count; ?>
                </span>
            </a>

        </nav>

    </div>

</header>

<style>
    .site-header {
        background-color: #ffffff;
        border-bottom: 1px solid #e5ddd3;
        border-radius: 12px;
        padding: 18px 24px;
        margin-bottom: 30px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.04);
    }

    .header-inner {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .site-logo {
        color: #3d342b;
        font-size: 1.6rem;
        font-weight: bold;
        text-decoration: none;
    }

    .site-nav {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .site-nav .nav-link {
        color: #70543e;
        text-decoration: none;
        font-weight: 600;
    }

    .site-nav .nav-link:hover {
        color: #3d342b;
    }

    .cart-count {
        display: inline-block;
        background-color: #70543e;
        color: #ffffff;
        border-radius: 20px;
        padding: 3px 9px;
        font-size: 0.85rem;
    }

    @media (max-width: 600px) {
        .header-inner {
            flex-direction: column;
            align-items: flex-start;
        }

        .site-nav {
            flex-wrap: wrap;
            gap: 14px;
        }
    }
</style>

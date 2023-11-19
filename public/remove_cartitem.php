<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["product_id"])) {
        $product_id = $_POST["product_id"];

        // Eliminar el producto del carrito
        unset($_SESSION['cart'][$product_id]);
    }
}

header("Location: cart.php");
exit();
?>

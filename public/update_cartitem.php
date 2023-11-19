<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["product_id"]) && isset($_POST["quantity"])) {
        $product_id = $_POST["product_id"];
        $quantity = $_POST["quantity"];

        // Verificar que la cantidad sea válida (mayor que cero)
        if ($quantity > 0) {
            // Actualizar la cantidad en el carrito
            $_SESSION['cart'][$product_id] = $quantity;
        } else {
            // Si la cantidad es cero o negativa, eliminar el producto del carrito
            unset($_SESSION['cart'][$product_id]);
        }
    }
}

header("Location: cart.php");
exit();
?>

<?php
session_start(); // Asegúrate de iniciar la sesión si no lo has hecho ya

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $cantidad = $_POST['cantidad'];

    // Insertar nuevo CartItem en la base de datos
    $user_id = $_SESSION['id']; 
    $sql = "INSERT INTO CartItem (user_id, product_id, cantidad) VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $user_id, $product_id, $cantidad);

    if ($stmt->execute()) {
        // Actualizar $_SESSION['cart'] con el nuevo producto
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }
        $_SESSION['cart'][$product_id] = $cantidad;

        // Redirigir a la página de productos
        header("Location: productos.php");
        exit(); // Asegúrate de detener la ejecución después de la redirección
    } else {
        echo "Error al añadir el producto al carrito: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

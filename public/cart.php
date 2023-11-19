<!DOCTYPE html>
<html lang="en">

<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-xwqOWtWZFQ+ZD/z3+Ut+DvC7DP0LUshKE0lIK7oXE1sB+MDDs3l9a3IwbpRfHKqy1lZj7Zf3ny1w2pN1eAQYOw==" crossorigin="anonymous" />
    <style>
         body {
            font-family: Arial, sans-serif;
        }

        .cart-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin: 20px;
            flex-direction: row; /* Cambié la dirección a row */
        }

        .product-card {
            border: 1px solid #ccc;
            padding: 20px;
            margin: 10px;
            width: 200px;
            text-align: center;
        }

        .add-to-cart-button {
            margin-top: 10px;
        }

        .pago-button {
            margin-top: 20px;
            text-decoration: none;
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    
  <!-- Barra de navegación de Bootstrap -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">ComputerBeef</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="cart.php">
                        <i class="fas fa-shopping-cart"></i> Carrito
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="login.html">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="productos.php">Productos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="signout.html">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </nav>

    <h2>Carrito de Compras</h2>

    <div class="cart-container">
        <?php
        session_start();
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "shop";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if (!isset($_SESSION["email"])) {
            header("Location: login.html");
            exit();
        }

        if ($conn->connect_error) {
            die("La conexión falló: " . $conn->connect_error);
        }

        if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
            foreach ($_SESSION['cart'] as $product_id => $quantity) {
                $sql = "SELECT * FROM Producto WHERE id = $product_id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
        ?>
                        <div class="product-card">
                        <img src="<?php echo $row['img']; ?>" alt="<?php echo $row['nombreProducto']; ?>" style="max-width: 100px; max-height: 100px;">
                            <h2><?php echo $row['nombreProducto']; ?></h2>
                            <p><?php echo $row['descripcion']; ?></p>
                            <p>Precio: €<?php echo $row['precio']; ?></p>
                            <form action="update_cartitem.php" method="POST">
                                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                <label for="quantity">Cantidad:</label>
                                <input type="number" name="quantity" value="<?php echo $quantity; ?>" min="1" max="10">
                                <input type="submit" value="Actualizar">
                            </form>
                            <form action="remove_cartitem.php" method="POST">
                                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                <input type="submit" value="Eliminar">
                            </form>
                        </div>
        <?php
                    }
                }
            }
        } else {
            echo "<p>No hay productos en el carrito.</p>";
        }

        $conn->close();
        ?>
    </div>

   <!-- Formulario para procesar el pago con Stripe -->
<form action="realizar_pago.php" method="POST" class="text-center">
    <script
        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
        data-key="pk_test_51ODnBhB8npZc25UN1xe9lkFRtphrQi58lPKi0oNJUs39a6HmkTYpH4s3cIRKmK0pcxMqBVIT1p8QsZ0RgeGF1DHf00elMhdCGi"
        data-amount=""  
        data-name="ComputerBeef"
        data-description="Productos en el carrito"
        data-currency="eur"
        data-locale="auto"
        data-zip-code="true"
    ></script>
</form>

</body>

</html>

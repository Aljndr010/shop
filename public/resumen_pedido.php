<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-xwqOWtWZFQ+ZD/z3+Ut+DvC7DP0LUshKE0lIK7oXE1sB+MDDs3l9a3IwbpRfHKqy1lZj7Zf3ny1w2pN1eAQYOw==" crossorigin="anonymous" />
    <title>Resumen de tu Pedido</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .summary-container {
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            max-width: 600px;
            text-align: center;
            margin: auto;
        }

        .summary-header {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .summary-details {
            font-size: 18px;
            margin-bottom: 10px;
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


    <h1>Resumen de Tu Pedido</h1>
    <div class="summary-container">
        <div class="summary-header"></div>

        <?php
        // Obtén la información del pedido de la base de datos
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "shop";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("La conexión falló: " . $conn->connect_error);
        }

        // Recupera la información del último pedido (ajusta según tu estructura de base de datos)
        $sql = "SELECT * FROM pedido ORDER BY id DESC LIMIT 1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        ?>
            <div class="summary-details">
                <p><strong>Fecha:</strong> <?php echo $row['fecha']; ?></p>
                <p><strong>Dirección de Envío:</strong> <?php echo $row['direccion']; ?></p>
                <p><strong>Titular de la Tarjeta:</strong> <?php echo $row['cardHolder']; ?></p>
                <p><strong>Número de Tarjeta:</strong> <?php echo $row['cardNumber']; ?></p>
            </div>
        <?php
        } else {
            echo "<p>No se encontró información del pedido.</p>";
        }

        $conn->close();
        ?>
        <p>Gracias por tu compra en ComputerBeef.</p>
    </div>
</body>

</html>

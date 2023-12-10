<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <!-- Agregamos la referencia al archivo CSS de Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-xwqOWtWZFQ+ZD/z3+Ut+DvC7DP0LUshKE0lIK7oXE1sB+MDDs3l9a3IwbpRfHKqy1lZj7Zf3ny1w2pN1eAQYOw==" crossorigin="anonymous" />

    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .product-card {
            border: 1px solid #ddd;
            padding: 20px;
            margin: 10px;
            text-align: center;
            transition: box-shadow 0.3s;
        }

        .product-card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .add-to-cart-button {
            margin-top: 10px;
        }
    </style>
    <!-- Matomo -->
<script>
  var _paq = window._paq = window._paq || [];
  /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="//localhost/matomo/";
    _paq.push(['setTrackerUrl', u+'matomo.php']);
    _paq.push(['setSiteId', '1']);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<!-- End Matomo Code -->
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

        <!-- Sección del Producto Destacado -->
        <div class="container mt-4 featured-product">
        <h2>Producto Destacado</h2>
        <img src="ruta/a/imagen_del_producto_destacado.jpg" alt="Producto Destacado">
        <p class="featured-product-description">Descripción atractiva del producto destacado. Puedes resaltar las características especiales y promociones aquí.</p>
    </div>

    <div class="container mt-4">
        <div class="row">
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "shop";

            $conn = new mysqli($servername, $username, $password, $dbname);

            // Verifica si el usuario ha iniciado sesión
            session_start();
            if (!isset($_SESSION["email"])) {
                // Si el usuario no ha iniciado sesión, redirige a la página de inicio de sesión
                header("Location: login.html");
                exit();
            }

            if ($conn->connect_error) {
                die("La conexión falló: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM Producto";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                    <div class="col-md-4">
                        <div class="card product-card">
                            <img src="<?php echo $row['img']; ?>" class="card-img-top" alt="<?php echo $row['nombreProducto']; ?>" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['nombreProducto']; ?></h5>
                                <p class="card-text"><?php echo $row['descripcion']; ?></p>
                                <p class="card-text">Precio: €<?php echo $row['precio']; ?></p>
                                <form action="agregar_cartitem.php" method="POST">
                                    <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                    <label for="cantidad">Cantidad:</label>
                                    <input type="number" name="cantidad" value="1" min="1" max="10">
                                    <input type="submit" class="btn btn-success add-to-cart-button" value="Añadir al Carrito">
                                </form>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "No hay productos disponibles.";
            }

            $conn->close();
            ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    

</body>

</html>
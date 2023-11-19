<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>

    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color: #333;
            overflow: hidden;
        }

        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }

        .login-container {
            width: 300px;
            margin: 0 auto;
            margin-top: 100px;
        }

        .login-form {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            font-size: 16px;
        }

        .form-group button {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }
            .register-button {
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
<div class="navbar">
        <a href="/cart.html">Cart</a>
        <a href="/login.html">Login</a>
        <a href="productos.php">Productos</a>
    </div>

    <h1>ComputerBeef</h1>

    <h2>Bienvenido!</h2>

    <?php

    // Verifica si existe una cookie con la última visita
    if (isset($_COOKIE['last_visit'])) {
        $lastVisit = $_COOKIE['last_visit'];
        echo "<p>Última visita: $lastVisit</p>";
    } else {
        echo "<p>Es tu primera visita.</p>";
    }

    // Guarda la fecha y hora actual en una cookie
    $currentDateTime = date('Y-m-d H:i:s');
    setcookie('last_visit', $currentDateTime, time() + 3600 * 24 * 30); // Cookie válida por 30 días

    echo "<p>Fecha y Hora actuales: $currentDateTime</p>";

    // Contador de visitas usando una cookie
    $visitCount = 1;
    if (isset($_COOKIE['visit_count'])) {
        $visitCount = $_COOKIE['visit_count'] + 1;
    }

    setcookie('visit_count', $visitCount, time() + 3600 * 24 * 30); // Cookie válida por 30 días

    echo "<p>Esta es tu visita número: $visitCount</p>";
    ?>
</body>

</html>

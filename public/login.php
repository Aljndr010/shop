<?php
// Establecer la conexión a la base de datos (reemplaza con tus propias credenciales)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shop";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar si la conexión a la base de datos es exitosa
if ($conn->connect_error) {
    die("La conexión a la base de datos falló: " . $conn->connect_error);
}

// Recuperar los datos del formulario
$email = $_POST["email"];
$password = $_POST["password"];

// Consulta para verificar las credenciales del usuario en la base de datos
$sql = "SELECT * FROM usuario WHERE email='$email' AND password='$password'";
$result = $conn->query($sql);

// Verificar si se encontró un usuario con las credenciales proporcionadas
if ($result->num_rows > 0) {
    // Iniciar la sesión
    session_start();

    // Almacenar el email del usuario en la sesión (o cualquier otra información que necesites)
    $_SESSION["email"] = $email;
    
    // Inicio de sesión exitoso, redirigir a la página de bienvenida
    header("Location: productos.php");
    exit();
} else {
    // Credenciales incorrectas, redirigir a la página de inicio de sesión con un mensaje de error
    header("Location: login.html?error=1");
    exit();
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
